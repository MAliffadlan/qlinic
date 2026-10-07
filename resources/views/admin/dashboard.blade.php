@extends('layouts.admin')

@section('title', 'Admin Dashboard - Qlinic')
@section('title_header', 'Ikhtisar Layanan Pasien')

@section('content')
<div class="grid grid-cols-2" style="margin-bottom: 24px;">
    @foreach($services as $service)
    <div class="card">
        <h3 style="font-size: 18px; color: var(--text-main); margin-bottom: 20px;">{{ $service->name }} <span style="color: var(--text-muted); font-size: 14px; font-weight: normal;">({{ $service->code }})</span></h3>
        
        @php
            $serviceQueues = $queues->where('service_id', $service->id);
            $calling = $serviceQueues->where('status', 'calling')->first();
            $waiting = $serviceQueues->where('status', 'waiting')->count();
        @endphp

        <div style="background: #F8FAFC; border: 1px solid var(--border-color); padding: 24px; border-radius: var(--radius-md); margin-bottom: 24px; text-align: center;">
            <p style="color: var(--text-muted); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Sedang Dilayani</p>
            @if($calling)
                <h1 style="color: var(--primary); font-size: 48px; font-weight: 700; margin: 0; line-height: 1.2;">{{ $calling->queue_number }}</h1>
                <p style="font-weight: 600; font-size: 16px; color: var(--text-main);">{{ $calling->user->name }}</p>
                
                <div style="margin-top: 20px; display: flex; gap: 12px; justify-content: center;">
                    <form action="{{ route('admin.queue.update', $calling->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn btn-success">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Selesai
                        </button>
                    </form>
                    <form action="{{ route('admin.queue.update', $calling->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="skipped">
                        <button type="submit" class="btn btn-danger">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Lewati
                        </button>
                    </form>
                </div>
            @else
                <h1 style="color: #CBD5E1; font-size: 36px; margin: 16px 0;">--</h1>
                <p style="color: var(--text-muted); font-size: 14px;">Belum ada panggilan</p>
            @endif
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 20px;">
            <div>
                <span class="badge badge-warning" style="font-size: 14px; padding: 6px 16px;">
                    Sisa Antrean: {{ $waiting }}
                </span>
            </div>
            
            <form action="{{ route('admin.queue.next') }}" method="POST">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <button type="submit" class="btn btn-primary" {{ $waiting == 0 ? 'disabled' : '' }} style="{{ $waiting == 0 ? 'opacity: 0.5; cursor: not-allowed;' : '' }}">
                    Panggil Berikutnya
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <h3 style="font-size: 18px; margin-bottom: 20px;">Daftar Antrean Hari Ini</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No Antrean</th>
                    <th>Nama Pasien</th>
                    <th>Layanan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($queues as $item)
                <tr>
                    <td style="font-weight: 700; color: var(--primary);">{{ $item->queue_number }}</td>
                    <td style="font-weight: 500;">{{ $item->user->name }}</td>
                    <td>{{ $item->service->name }}</td>
                    <td>
                        @if($item->status == 'waiting')
                            <span class="badge badge-warning">Menunggu</span>
                        @elseif($item->status == 'calling')
                            <span class="badge badge-info">Pemanggilan</span>
                        @elseif($item->status == 'completed')
                            <span class="badge badge-success">Selesai</span>
                        @else
                            <span class="badge badge-danger">Dilewati</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center" style="color: var(--text-muted); padding: 40px 0;">Belum ada data rekaman antrean hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
