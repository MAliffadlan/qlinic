<?php

namespace Tests\Feature;

use App\Models\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSidebarTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sidebar_has_clear_navigation_and_accessible_drawer_controls(): void
    {
        $admin = User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin-sidebar@example.test',
            'nik' => '3307010101000099',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertOk();
        $content = $response->getContent();

        $this->assertSame(0, $this->elementCount($content, '//*[@class="admin-sidebar__eyebrow" or @class="admin-sidebar__label" or @class="admin-nav__icon" or @class="admin-sidebar__note" or @class="avatar"]'), 'Decorative dashboard-template elements must be removed.');
        $this->assertSame(1, $this->elementCount($content, '//a[contains(concat(" ", normalize-space(@class), " "), " admin-nav__link ") and @aria-current="page" and normalize-space()="01 Dashboard"]'));
        $this->assertSame(1, $this->elementCount($content, '//nav[contains(concat(" ", normalize-space(@class), " "), " admin-nav ")]/a[@aria-current="page"]/span[contains(concat(" ", normalize-space(@class), " "), " admin-nav__index ") and normalize-space()="01" and @aria-hidden="true"]'));
        $this->assertSame(3, $this->elementCount($content, '//nav[contains(concat(" ", normalize-space(@class), " "), " admin-nav ")]/a'));
        $this->assertSame(1, $this->elementCount($content, '//nav[contains(concat(" ", normalize-space(@class), " "), " admin-nav ")]/a[normalize-space()="02 Layar TV" and @href="'.route('admin.display').'" and not(@target)]'));
        $this->assertSame(1, $this->elementCount($content, '//nav[contains(concat(" ", normalize-space(@class), " "), " admin-nav ")]/a[normalize-space()="03 Layar TV Publik" and @href="'.route('queue.display').'" and @target="_blank" and contains(concat(" ", normalize-space(@rel), " "), " noopener ") and @aria-label="Layar TV Publik, buka di tab baru"]'));
        $this->assertSame(1, $this->elementCount($content, '//nav[contains(concat(" ", normalize-space(@class), " "), " admin-nav ")]/a[@target="_blank"]/span[contains(concat(" ", normalize-space(@class), " "), " admin-nav__index ") and normalize-space()="03" and @aria-hidden="true"]'));
        $this->assertSame(1, $this->elementCount($content, '//*[contains(concat(" ", normalize-space(@class), " "), " admin-user__role ") and normalize-space()="Administrator"]'));
        $this->assertSame(1, $this->elementCount($content, '//form[@action="'.route('logout').'"][@method="POST"]//button[@type="submit" and normalize-space()="Keluar"]'));
        $this->assertSame(1, $this->elementCount($content, '//aside[@id="admin-navigation"]'));
        $this->assertSame(1, $this->elementCount($content, '//button[contains(concat(" ", normalize-space(@class), " "), " admin-menu-btn ")][@aria-controls="admin-navigation"][@aria-expanded="false"][contains(concat(" ", normalize-space(@class), " "), " js-sidebar-open ")]'));
        $this->assertSame(1, $this->elementCount($content, '//button[contains(concat(" ", normalize-space(@class), " "), " admin-sidebar__close ")][@data-sidebar-close]'));
        $this->assertSame(1, $this->elementCount($content, '//button[@data-sidebar-close and contains(concat(" ", normalize-space(@class), " "), " admin-backdrop ")][@aria-label="Tutup navigasi admin"]'));
        $this->assertSame(0, $this->elementCount($content, '//div[@data-sidebar-toggle]'));
        $this->assertSame(0, $this->elementCount($content, '//script[contains(@src, "/js/qlinic.js")]'), 'The legacy drawer controller must not conflict with the accessible admin controller.');
        $this->assertSame(1, $this->elementCount($content, '//script[contains(@src, "/js/admin-sidebar.js") and @defer]'));
        $this->assertSame(1, $this->elementCount($content, '//form[@action="'.route('logout').'"][@method="POST"]//input[@type="hidden" and @name="_token" and normalize-space(@value)!=""]'), 'Logout must retain its CSRF token.');
        $this->assertSame(0, $this->elementCount($content, '//header[contains(concat(" ", normalize-space(@class), " "), " admin-topbar ")]//a[normalize-space()="Buka layar TV"]'), 'The duplicate TV shortcut must be removed from the topbar.');
        $this->assertSame(1, $this->elementCount($content, '//header[contains(concat(" ", normalize-space(@class), " "), " admin-topbar ")]//*[contains(concat(" ", normalize-space(@class), " "), " admin-topbar__date ")]'), 'The real date remains in the topbar.');
        $this->assertSame(1, $this->elementCount($content, '//nav[contains(concat(" ", normalize-space(@class), " "), " admin-nav ")]//a[@href="'.route('queue.display').'" and @target="_blank" and contains(concat(" ", normalize-space(@rel), " "), " noopener ")]'), 'The sidebar must retain the public TV shortcut.');
        $this->assertSame(1, $this->elementCount($content, '//nav[contains(concat(" ", normalize-space(@class), " "), " admin-nav ")]//a[@href="'.route('admin.display').'" and not(@target)]'), 'The admin TV shortcut must stay within the dashboard.');
    }

    private function elementCount(string $html, string $query): int
    {
        $document = new DOMDocument;
        @$document->loadHTML($html);

        return (new DOMXPath($document))->query($query)->length;
    }
}
