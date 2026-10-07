<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Queue;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    public function adminDashboard()
    {
        if (Auth::user()->role !== 'admin') abort(403);
        
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
        $queue = Queue::findOrFail($id);
        $queue->update(['status' => $request->status]);
        return back()->with('success', 'Status antrean diperbarui');
    }

    public function patientDashboard()
    {
        if (Auth::user()->role !== 'patient') abort(403);
        
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
            
        $queueNumber = $service->code . '-' . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
        
        Queue::create([
            'service_id' => $service->id,
            'user_id' => Auth::id(),
            'queue_number' => $queueNumber,
            'status' => 'waiting',
            'date' => $today
        ]);
        
        return back()->with('success', 'Berhasil mengambil antrean.');
    }

    public function liveDisplay()
    {
        return view('patient.display');
    }

    public function liveStatusAPI()
    {
        $today = date('Y-m-d');
        
        // Get currently calling queue for each service
        $status = Service::with(['queues' => function($q) use ($today) {
            $q->where('date', $today)
              ->where('status', 'calling')
              ->with('user');
        }])->get();
        
        return response()->json($status);
    }
}
