@extends('layouts.app')

@section('title', 'Dashboard Pasien - Qlinic')

@section('content')
<div class="mb-4 text-center" style="margin-bottom: 24px; margin-top: 16px;">
    <h1 style="font-size: 30px; font-weight: 700; color: var(--primary); margin-bottom: 8px;">Pusat Antrean Mandiri</h1>
    <p style="color: var(--text-muted); font-size: 15px;">Pantau status panggilan klinik dan kelola tiket Anda dari telepon genggam.</p>
</div>

<!-- Status Antrean Berjalan (Informasi Global) -->
<div class="card" style="background: var(--primary); color: var(--white); border: none; overflow: hidden; position: relative; margin-bottom: 24px;">
    <!-- decorative bg -->
    <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
    
    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; color: var(--white); display: flex; align-items: center; gap: 8px; position:relative; z-index: 2;">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
        Status Panggilan Poli Klinik (Saat Ini)
    </h3>
    <div class="grid @if($services->count() >= 3) grid-cols-3 @else grid-cols-2 @endif" style="gap: 16px; position:relative; z-index: 2;">
        @foreach($services as $service)
            @php
                $calling = $currentCallings->where('service_id', $service->id)->first();
            @endphp
            <div style="background: rgba(255, 255, 255, 0.1); border-radius: var(--radius-lg); padding: 20px; text-align: center; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                <p style="font-weight: 600; font-size: 14px; margin-bottom: 12px; opacity: 0.9;">{{ $service->name }}</p>
                @if($calling)
                    <h2 style="font-size: 36px; font-weight: 800; line-height: 1; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">{{ $calling->queue_number }}</h2>
                @else
                    <h2 style="font-size: 28px; font-weight: 700; line-height: 1; margin: 0; opacity: 0.5;">--</h2>
                    <p style="font-size: 13px; margin-top: 8px; opacity: 0.7;">Sedang Kosong</p>
                @endif
            </div>
        @endforeach
    </div>
</div>

<div class="grid grid-cols-2">
    <!-- Pengambilan Antrean -->
    <div class="card" style="border-top: 4px solid var(--primary); height: fit-content;">
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--primary);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            Ambil Tiket Pendaftaran
        </h3>
        <p class="mb-4" style="color: var(--text-muted); font-size: 14px; line-height: 1.5;">Pilih layanan Poli yang tersedia untuk hari ini. Batas 1 tiket poli per harinya.</p>
        
        <form action="{{ route('patient.queue.take') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom: 24px;">
                <label for="service_id" class="form-label" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Pilih Layanan Poli</label>
                <select name="service_id" id="service_id" class="form-control" required style="cursor: pointer; padding: 14px 16px; padding-right: 48px; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%2364748B%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpolyline points=%226 9 12 15 18 9%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 20px center; background-size: 16px;">
                    <option value="">-- Klik untuk Memilih --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" style="padding: 10px;">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block" style="padding: 14px; font-size: 15px;">Minta Nomor Antrean</button>
        </form>
    </div>

    <!-- Status Antrean Saya -->
    <div class="card" style="background: linear-gradient(145deg, #ffffff 0%, #F8FAFC 100%);">
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--primary);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Tiket Saya
        </h3>
        
        <!-- Scrollable container applied here -->
        <div class="custom-scrollbar" style="max-height: 380px; overflow-y: auto; padding-right: 8px;">
            <style>
                .custom-scrollbar::-webkit-scrollbar { width: 6px; }
                .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
                .custom-scrollbar::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 4px; }
                .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
            </style>
            @if($myQueues->count() > 0)
                <div class="grid" style="gap: 16px;">
                    @foreach($myQueues as $queue)
                        <div style="background: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 16px; display: flex; justify-content: space-between; align-items: center; box-shadow: var(--shadow-sm); position: relative; overflow: hidden;">
                            
                            <!-- Decorative left border based on status -->
                            <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 6px; 
                                @if($queue->status == 'waiting') background: #F59E0B;
                                @elseif($queue->status == 'calling') background: var(--primary);
                                @elseif($queue->status == 'completed') background: #10B981;
                                @else background: #EF4444;
                                @endif
                            "></div>

                            <div style="padding-left: 12px; flex-grow: 1;">
                                <p style="font-weight: 700; font-size: 15px; margin-bottom: 6px; color: var(--text-main);">{{ $queue->service->name }}</p>
                                <span class="badge 
                                    @if($queue->status == 'waiting') badge-warning
                                    @elseif($queue->status == 'calling') badge-info
                                    @elseif($queue->status == 'completed') badge-success
                                    @else badge-danger
                                    @endif
                                " style="font-size: 11px; padding: 4px 10px;">
                                    @if($queue->status == 'waiting') MENUNGGU GILIRAN
                                    @elseif($queue->status == 'calling') SILAKAN MASUK
                                    @elseif($queue->status == 'completed') SUDAH SELESAI
                                    @else DILEWATI
                                    @endif
                                </span>
                                
                                @if($queue->status == 'waiting')
                                <div style="margin-top: 12px; background: #FFFBEB; border: 1px solid #FEF3C7; padding: 10px; border-radius: 8px;">
                                    <p style="font-size: 13px; color: #B45309; margin-bottom: 4px; font-weight: 600;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Estimasi: ~{{ $queue->estimation_minutes }} Menit
                                    </p>
                                    <p style="font-size: 12px; color: #D97706;">Ada {{ $queue->ahead_count }} antrean di depan Anda</p>
                                </div>
                                @endif
                                
                            </div>
                            <div style="text-align: right; margin-left: 16px;">
                                <h2 style="color: var(--primary); margin: 0; font-size: 32px; font-weight: 800; line-height: 1;">{{ $queue->queue_number }}</h2>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 40px 20px; border: 2px dashed var(--border-color); border-radius: var(--radius-lg);">
                    <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #CBD5E1; margin: 0 auto 12px auto;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p style="color: var(--text-muted); font-size: 14px; font-weight: 500;">Anda belum mengambil tiket poli di hari ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
