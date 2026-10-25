<?php

namespace Tests\Feature;

use App\Models\Queue;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminQueueAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private int $nikSequence = 0;

    private function makeUser(string $role, string $email, string $name): User
    {
        $this->nikSequence++;

        return User::create([
            'name' => $name,
            'email' => $email,
            'nik' => '33070101'.str_pad((string) $this->nikSequence, 8, '0', STR_PAD_LEFT),
            'password' => Hash::make('password'),
            'role' => $role,
        ]);
    }

    private function makeService(): Service
    {
        return Service::create(['name' => 'Poli Test', 'code' => 'TST']);
    }

    private function makeQueue(User $patient, Service $service, string $status = 'waiting'): Queue
    {
        return Queue::create([
            'service_id' => $service->id,
            'user_id' => $patient->id,
            'queue_number' => 'TST-001',
            'status' => $status,
            'date' => today()->toDateString(),
        ]);
    }

    public function test_patient_cannot_call_next_queue(): void
    {
        $service = $this->makeService();
        $patient = $this->makeUser('patient', 'patient-call@example.test', 'Patient Call');
        $victim = $this->makeUser('patient', 'victim-call@example.test', 'Victim Call');
        $queue = $this->makeQueue($victim, $service);

        $response = $this->actingAs($patient)->post(route('admin.queue.next'), [
            'service_id' => $service->id,
        ]);

        $response->assertForbidden();
        $this->assertSame('waiting', $queue->fresh()->status);
    }

    public function test_patient_cannot_update_queue_status(): void
    {
        $service = $this->makeService();
        $patient = $this->makeUser('patient', 'patient-update@example.test', 'Patient Update');
        $victim = $this->makeUser('patient', 'victim-update@example.test', 'Victim Update');
        $queue = $this->makeQueue($victim, $service, 'calling');

        $response = $this->actingAs($patient)->post(route('admin.queue.update', $queue->id), [
            'status' => 'completed',
        ]);

        $response->assertForbidden();
        $this->assertSame('calling', $queue->fresh()->status);
    }

    public function test_patient_cannot_view_admin_dashboard(): void
    {
        $patient = $this->makeUser('patient', 'patient-read@example.test', 'Patient Read');

        $this->actingAs($patient)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_call_next_queue(): void
    {
        $service = $this->makeService();
        $admin = $this->makeUser('admin', 'admin-call@example.test', 'Admin Call');
        $patient = $this->makeUser('patient', 'patient-next@example.test', 'Patient Next');
        $queue = $this->makeQueue($patient, $service);

        $response = $this->actingAs($admin)->post(route('admin.queue.next'), [
            'service_id' => $service->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Antrean selanjutnya dipanggil');
        $this->assertSame('calling', $queue->fresh()->status);
    }

    public function test_admin_can_complete_calling_queue(): void
    {
        $service = $this->makeService();
        $admin = $this->makeUser('admin', 'admin-complete@example.test', 'Admin Complete');
        $patient = $this->makeUser('patient', 'patient-complete@example.test', 'Patient Complete');
        $queue = $this->makeQueue($patient, $service, 'calling');

        $response = $this->actingAs($admin)->post(route('admin.queue.update', $queue->id), [
            'status' => 'completed',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Status antrean diperbarui');
        $this->assertSame('completed', $queue->fresh()->status);
    }
}
