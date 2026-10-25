<?php

namespace Tests\Feature;

use App\Models\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_tv_stays_in_workspace_and_uses_public_live_status(): void
    {
        $admin = User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin-tv-workspace@example.test',
            'nik' => '3307010101000096',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.display'));
        $response->assertOk();
        $content = $response->getContent();

        $this->assertSame(1, $this->elementCount($content, '//aside[@id="admin-navigation"]'));
        $this->assertSame(1, $this->elementCount($content, '//a[@href="'.route('admin.display').'" and @aria-current="page" and normalize-space()="02 Layar TV"]'));
        $this->assertSame(1, $this->elementCount($content, '//main//*[@id="admin-tv-services" and @data-status-url="'.route('queue.api.status').'"]'));
        $this->assertSame(1, $this->elementCount($content, '//*[@id="admin-tv-connection" and @role="status"]'));
        $this->assertSame(1, $this->elementCount($content, '//*[@id="admin-tv-announcer" and @aria-live="polite"]'));
        $this->assertSame(1, $this->elementCount($content, '//script[contains(@src, "/js/admin-tv.js") and @defer]'));
        $this->assertSame(0, $this->elementCount($content, '//iframe'), 'The admin TV must be integrated into the workspace, not a public page iframe.');
        $this->assertSame(0, $this->elementCount($content, '//*[@class="tv-shell"]'), 'The public TV must not be replaced by the admin workspace.');
        $this->assertSame(1, $this->elementCount($content, '//noscript//a[@href="'.route('queue.display').'"]'), 'No-JavaScript users retain a path to the public display.');
    }

    public function test_public_tv_keeps_its_existing_presentation(): void
    {
        $response = $this->get(route('queue.display'));
        $response->assertOk();
        $content = $response->getContent();
        $this->assertSame(1, $this->elementCount($content, '//*[contains(concat(" ", normalize-space(@class), " "), " tv-shell ")]'));
        $this->assertSame(0, $this->elementCount($content, '//aside[@id="admin-navigation"]'));
        $this->assertStringContainsString('function tickClock()', $content);
        $this->assertSame(1, $this->elementCount($content, '//*[@id="display-container"]'));
    }

    private function elementCount(string $html, string $query): int
    {
        $document = new DOMDocument;
        @$document->loadHTML($html);

        return (new DOMXPath($document))->query($query)->length;
    }
}
