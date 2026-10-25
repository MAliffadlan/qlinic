<?php

namespace Tests\Feature;

use App\Models\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminToastTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_flash_messages_render_as_dismissible_toasts(): void
    {
        $admin = User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin-toast@example.test',
            'nik' => '3307010101000098',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
            ->withSession(['success' => 'Antrean selanjutnya dipanggil', 'error' => 'Contoh kegagalan aksi'])
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $content = $response->getContent();
        $this->assertSame(1, $this->elementCount($content, '//main[@id="konten" and @tabindex="-1"]'), 'Dismissal must be able to restore keyboard focus to the dashboard content.');
        $this->assertSame(1, $this->elementCount($content, '//*[@id="admin-notifications" and @aria-label="Notifikasi dashboard"]'));
        $this->assertSame(1, $this->elementCount($content, '//*[@id="admin-notifications"]//*[@role="status" and contains(concat(" ", normalize-space(@class), " "), " admin-toast ")]//*[contains(concat(" ", normalize-space(@class), " "), " admin-toast__message ") and normalize-space()="Antrean selanjutnya dipanggil"]'));
        $this->assertSame(1, $this->elementCount($content, '//*[@id="admin-notifications"]//*[@role="alert" and contains(concat(" ", normalize-space(@class), " "), " admin-toast ")]//*[normalize-space()="Contoh kegagalan aksi"]'));
        $this->assertSame(2, $this->elementCount($content, '//*[@id="admin-notifications"]//button[@type="button" and @data-toast-dismiss and @aria-label="Tutup notifikasi"]'));
        $this->assertSame(0, $this->elementCount($content, '//main//*[@role="status" or @role="alert"]'), 'Admin flash messages must not occupy the main queue layout.');
        $this->assertSame(1, $this->elementCount($content, '//script[contains(@src, "/js/admin-toast.js") and @defer]'));
    }

    public function test_dashboard_without_flash_has_no_notification_elements(): void
    {
        $admin = User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin-no-toast@example.test',
            'nik' => '3307010101000097',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $content = $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk()->getContent();
        $this->assertSame(0, $this->elementCount($content, '//*[@id="admin-notifications"]'));
        $this->assertSame(1, $this->elementCount($content, '//script[contains(@src, "/js/admin-toast.js") and @defer]'));
    }

    private function elementCount(string $html, string $query): int
    {
        $document = new DOMDocument;
        @$document->loadHTML($html);

        return (new DOMXPath($document))->query($query)->length;
    }
}
