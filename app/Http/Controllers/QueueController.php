<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class QueueController extends Controller
{
    public function adminDashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $services = Service::all();
        $today = date('Y-m-d');

        $queues = Queue::with(['user', 'service'])
            ->where('date', $today)
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.dashboard', compact('services', 'queues'));
    }

    public function callNext(Request $request)
    {
        $request->validate(['service_id' => 'required|exists:services,id']);

        $today = date('Y-m-d');

        // Find if there's any currently calling queue for this service and mark it completed if they forgot
        Queue::where('service_id', $request->service_id)
            ->where('date', $today)
            ->where('status', 'calling')
            ->update(['status' => 'completed']);

        // Find next waiting queue
        $nextQueue = Queue::where('service_id', $request->service_id)
            ->where('date', $today)
            ->where('status', 'waiting')
            ->orderBy('id', 'asc')
            ->first();

        if ($nextQueue) {
            $nextQueue->update(['status' => 'calling']);
        }

        return back()->with('success', 'Antrean selanjutnya dipanggil');
    }

    public function updateQueueStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Queue::STATUSES)],
        ]);

        $queue = Queue::where('date', today()->toDateString())->findOrFail($id);

        if ($validated['status'] === $queue->status) {
            return back()->with('success', 'Status antrean tidak berubah');
        }

        if (! $queue->canTransitionTo($validated['status'])) {
            throw ValidationException::withMessages([
                'status' => 'Transisi status antrean tidak valid.',
            ]);
        }

        $queue->update(['status' => $validated['status']]);

        return back()->with('success', 'Status antrean diperbarui');
    }

    public function patientDashboard()
    {
        if (Auth::user()->role !== 'patient') {
            abort(403);
        }

        $services = Service::all();
        $today = date('Y-m-d');

        $myQueues = Queue::with('service')
            ->where('user_id', Auth::id())
            ->where('date', $today)
            ->get();

        // Hitung estimasi waktu untuk setiap antrean yang masih menunggu
        foreach ($myQueues as $queue) {
            if ($queue->status == 'waiting') {
                $ahead = Queue::where('service_id', $queue->service_id)
                    ->where('date', $today)
                    ->whereIn('status', ['waiting', 'calling'])
                    ->where('id', '<', $queue->id)
                    ->count();

                $queue->ahead_count = $ahead;
                $queue->estimation_minutes = $ahead * 15; // Asumsi 15 menit per antrean
            }
        }

        $currentCallings = Queue::with('service')
            ->where('date', $today)
            ->where('status', 'calling')
            ->get();

        return view('patient.dashboard', compact('services', 'myQueues', 'currentCallings'));
    }

    public function takeQueue(Request $request)
    {
        $request->validate(['service_id' => 'required|exists:services,id']);

        $today = date('Y-m-d');
        $service = Service::findOrFail($request->service_id);

        // Check if patient already took a queue today for this service
        $already = Queue::where('user_id', Auth::id())
            ->where('service_id', $service->id)
            ->where('date', $today)
            ->whereIn('status', ['waiting', 'calling'])
            ->exists();

        if ($already) {
            return back()->with('error', 'Anda sudah mengambil antrean untuk layanan ini.');
        }

        $countToday = Queue::where('service_id', $service->id)
            ->where('date', $today)
            ->count();

        $queueNumber = $service->code.'-'.str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);

        Queue::create([
            'service_id' => $service->id,
            'user_id' => Auth::id(),
            'queue_number' => $queueNumber,
            'status' => 'waiting',
            'date' => $today,
        ]);

        return back()->with('success', 'Berhasil mengambil antrean.');
    }

    public function adminDisplay()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.display');
    }

    public function liveDisplay()
    {
        return view('patient.display');
    }

    public function liveStatusAPI()
    {
        $today = today()->toDateString();

        $status = Service::query()
            ->select(['id', 'name', 'code'])
            ->with(['queues' => function ($q) use ($today) {
                $q->select(['id', 'service_id', 'user_id', 'queue_number', 'status', 'date'])
                    ->where('date', $today)
                    ->where('status', Queue::STATUS_CALLING)
                    ->with('user:id,name');
            }])
            ->get()
            ->map(function (Service $service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'code' => $service->code,
                    'queues' => $service->queues->map(function (Queue $queue) {
                        return [
                            'queue_number' => $queue->queue_number,
                            'status' => $queue->status,
                            'user' => [
                                'name' => $this->maskPatientName($queue->user?->name),
                            ],
                        ];
                    })->values(),
                ];
            });

        return response()
            ->json($status)
            ->header('Cache-Control', 'no-store, private');
    }

    private function maskPatientName(?string $name): string
    {
        $parts = preg_split('/\s+/', trim((string) $name), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        if ($parts === []) {
            return 'Pasien';
        }

        if (count($parts) === 1) {
            return $parts[0];
        }

        return $parts[0].' '.Str::upper(Str::substr($parts[array_key_last($parts)], 0, 1)).'.';
    }
}
