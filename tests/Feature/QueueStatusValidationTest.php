<?php

namespace Tests\Feature;

use App\Models\Queue;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class QueueStatusValidationTest extends TestCase
{
    use RefreshDatabase;

    private int $nikSequence = 0;

    private function makeUser(string $role, string $email, string $name): User
    {
        $this->nikSequence++;

        return User::create([
            'name' => $name,
            'email' => $email,
            'nik' => '33070102'.str_pad((string) $this->nikSequence, 8, '0', STR_PAD_LEFT),
            'password' => Hash::make('password'),
            'role' => $role,
        ]);
    }

    private function makeQueue(User $patient, Service $service, string $status, ?string $date = null): Queue
    {
        return Queue::create([
            'service_id' => $service->id,
            'user_id' => $patient->id,
            'queue_number' => 'TST-002',
            'status' => $status,
            'date' => $date ?? today()->toDateString(),
        ]);
    }

    public function test_admin_cannot_store_unknown_status(): void
    {
        $service = Service::create(['name' => 'Poli Test', 'code' => 'TST']);
        $admin = $this->makeUser('admin', 'admin-unknown@example.test', 'Admin Unknown');
        $patient = $this->makeUser('patient', 'patient-unknown@example.test', 'Patient Unknown');
        $queue = $this->makeQueue($patient, $service, 'calling');

        $response = $this->actingAs($admin)->post(route('admin.queue.update', $queue->id), [
            'status' => 'attacker-controlled',
        ]);

        $response->assertSessionHasErrors('status');
        $this->assertSame('calling', $queue->fresh()->status);
    }

    public function test_admin_cannot_move_completed_queue_back_to_waiting(): void
    {
        $service = Service::create(['name' => 'Poli Test', 'code' => 'TST']);
        $admin = $this->makeUser('admin', 'admin-transition@example.test', 'Admin Transition');
        $patient = $this->makeUser('patient', 'patient-transition@example.test', 'Patient Transition');
        $queue = $this->makeQueue($patient, $service, 'completed');

        $response = $this->actingAs($admin)->post(route('admin.queue.update', $queue->id), [
            'status' => 'waiting',
        ]);

        $response->assertSessionHasErrors('status');
        $this->assertSame('completed', $queue->fresh()->status);
    }

    public function test_admin_cannot_update_a_queue_from_another_day(): void
    {
        $service = Service::create(['name' => 'Poli Test', 'code' => 'TST']);
        $admin = $this->makeUser('admin', 'admin-date@example.test', 'Admin Date');
        $patient = $this->makeUser('patient', 'patient-date@example.test', 'Patient Date');
        $queue = $this->makeQueue($patient, $service, 'calling', today()->subDay()->toDateString());

        $response = $this->actingAs($admin)->post(route('admin.queue.update', $queue->id), [
            'status' => 'completed',
        ]);

        $response->assertNotFound();
        $this->assertSame('calling', $queue->fresh()->status);
    }
}
