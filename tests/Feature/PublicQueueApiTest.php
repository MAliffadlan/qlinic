<?php

namespace Tests\Feature;

use App\Models\Queue;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PublicQueueApiTest extends TestCase
{
    use RefreshDatabase;

    private int $nikSequence = 0;

    private function makePatient(string $name, string $email, string $nikSuffix): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'nik' => '33070103'.$nikSuffix,
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);
    }

    private function makeCallingQueue(User $patient, Service $service, ?string $date = null): Queue
    {
        return Queue::create([
            'service_id' => $service->id,
            'user_id' => $patient->id,
            'queue_number' => 'TST-003',
            'status' => 'calling',
            'date' => $date ?? today()->toDateString(),
        ]);
    }

    public function test_api_masks_patient_name(): void
    {
        $service = Service::create(['name' => 'Poli Test', 'code' => 'TST']);
        $patient = $this->makePatient('Siti Rahma', 'siti@example.test', '00000001');
        $this->makeCallingQueue($patient, $service);

        $response = $this->getJson('/api/live-status');

        $response->assertOk();
        $this->assertSame('Siti R.', $response->json('0.queues.0.user.name'));
    }

    public function test_api_omits_user_ids_and_contact_data(): void
    {
        $service = Service::create(['name' => 'Poli Test', 'code' => 'TST']);
        $patient = $this->makePatient('Siti Rahma', 'siti@example.test', '00000002');
        $this->makeCallingQueue($patient, $service);

        $response = $this->getJson('/api/live-status');
        $queue = $response->json('0.queues.0');
        $body = $response->getContent();

        $response->assertOk();
        $this->assertArrayNotHasKey('user_id', $queue);
        $this->assertStringNotContainsString('Siti Rahma', $body);
        $this->assertStringNotContainsString('siti@example.test', $body);
        $this->assertStringNotContainsString('3307010300000002', $body);
    }

    public function test_api_response_is_not_cacheable(): void
    {
        $service = Service::create(['name' => 'Poli Test', 'code' => 'TST']);
        $patient = $this->makePatient('Siti Rahma', 'siti@example.test', '00000003');
        $this->makeCallingQueue($patient, $service);

        $response = $this->getJson('/api/live-status');

        $response->assertOk();
        $this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
    }

    public function test_api_returns_only_today_calling_queues(): void
    {
        $service = Service::create(['name' => 'Poli Test', 'code' => 'TST']);
        $patient = $this->makePatient('Siti Rahma', 'siti@example.test', '00000004');
        $this->makeCallingQueue($patient, $service, today()->subDay()->toDateString());

        $response = $this->getJson('/api/live-status');

        $response->assertOk();
        $this->assertSame([], $response->json('0.queues'));
    }
}
