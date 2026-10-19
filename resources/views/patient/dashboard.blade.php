@extends('layouts.app')

@section('title', 'Dashboard Pasien — Qlinic')

@section('content')
    @php
        $now = \Carbon\Carbon::now('Asia/Jakarta')->locale('id');
        $hour = (int) $now->format('H');
        $greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));
        $firstName = explode(' ', trim(Auth::user()->name))[0];
        $activeServiceIds = $myQueues->whereIn('status', ['waiting', 'calling'])
            ->pluck('service_id')
            ->map(fn ($id) => (int) $id)
            ->all();
        $allServicesActive = $services->isNotEmpty() && count(array_unique($activeServiceIds)) >= $services->count();
    @endphp

    <div class="dashboard">
        <header class="page-intro">
            <div class="page-intro__copy">
                <span class="eyebrow">Pusat antrean mandiri</span>
                <h1>{{ $greeting }}, <em>{{ $firstName }}</em>.</h1>
                <p>Pantau panggilan poli dan kelola tiket Anda hari ini dari satu tempat.</p>
            </div>
            <span class="date-pill">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 11h18"/></svg>
                {{ $now->translatedFormat('l, d F Y') }}
            </span>
        </header>

        <section aria-label="Panggilan saat ini">
            <div class="call-strip">
                @forelse($services as $service)
                    @php
                        $calling = $currentCallings->firstWhere('service_id', $service->id);
                        $isMine = $calling && (int) $calling->user_id === (int) Auth::id();
                    @endphp
                    <article class="call-card {{ $calling ? 'is-active' : '' }} {{ $isMine ? 'is-mine' : '' }}">
                        <div class="call-card__top">
                            <span class="call-card__service">{{ $service->name }}</span>
                            <span class="call-card__state">{{ $calling ? 'Sedang dipanggil' : 'Belum ada panggilan' }}</span>
                        </div>
                        <div class="call-card__number {{ $calling ? '' : 'is-empty' }}">{{ $calling?->queue_number ?? '—' }}</div>
                        <p class="call-card__note">
                            {{ $calling ? 'Silakan menuju ruang poli.' : 'Nomor yang dipanggil akan muncul di sini.' }}
                        </p>
                        @if($isMine)
                            <span class="call-card__mine">Giliran Anda</span>
                        @endif
                    </article>
                @empty
                    <article class="call-card">
                        <div class="call-card__top">
                            <span class="call-card__service">Layanan</span>
                            <span class="call-card__state">Belum tersedia</span>
                        </div>
                        <div class="call-card__number is-empty">—</div>
                        <p class="call-card__note">Belum ada poli yang dibuka hari ini.</p>
                    </article>
                @endforelse
            </div>
        </section>

        <div class="dashboard-grid">
            <section class="panel" aria-labelledby="ambil-tiket">
                <div class="panel__head">
                    <div>
                        <h2 class="panel__title" id="ambil-tiket">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 5v2m0 4v2m0 4v2"/><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 1 0 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 1 0 0-4V7a2 2 0 0 1 2-2Z"/></svg>
                            Ambil tiket hari ini
                        </h2>
                        <p class="panel__sub">Pilih poli yang dituju. Satu tiket aktif per poli.</p>
                    </div>
                </div>

                @if($services->isEmpty())
                    <div class="empty-state">
                        <span class="empty-state__icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 21V8l8-5 8 5v13"/><path d="M9 21v-6h6v6"/></svg>
                        </span>
                        <strong>Belum ada poli tersedia</strong>
                        <p>Silakan hubungi petugas klinik untuk informasi layanan hari ini.</p>
                    </div>
                @else
                    <form action="{{ route('patient.queue.take') }}" method="POST">
                        @csrf

                        <div class="service-picker">
                            @foreach($services as $service)
                                @php $isActive = in_array((int) $service->id, $activeServiceIds, true); @endphp
                                <label class="service-option {{ $isActive ? 'is-disabled' : '' }}">
                                    <input
                                        type="radio"
                                        name="service_id"
                                        value="{{ $service->id }}"
                                        {{ $isActive ? 'disabled' : '' }}
                                        required
                                    >
                                    <span class="service-option__check" aria-hidden="true"></span>
                                    <span class="service-option__body">
                                        <span class="service-option__name">{{ $service->name }}</span>
                                        <span class="service-option__meta">
                                            {{ $isActive ? 'Anda sudah punya tiket aktif di poli ini.' : 'Estimasi tunggu ±15 menit per antrean.' }}
                                        </span>
                                    </span>
                                    <span class="service-option__code">{{ $service->code }}</span>
                                </label>
                            @endforeach
                        </div>

                        @if($allServicesActive)
                            <div class="callout">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg>
                                <span>Anda sudah memiliki tiket aktif untuk semua poli hari ini. Selesaikan atau tunggu panggilan terlebih dahulu.</span>
                            </div>
                        @else
                            <button class="btn btn-primary btn-block" type="submit">
                                Minta nomor antrean
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </button>
                            <p class="form-hint" style="text-align: center; margin-top: 0.65rem;">Nomor langsung terbit setelah dikonfirmasi.</p>
                        @endif
                    </form>
                @endif
            </section>

            <section class="panel panel--soft" aria-labelledby="tiket-saya">
                <div class="panel__head">
                    <div>
                        <h2 class="panel__title" id="tiket-saya">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
                            Tiket saya hari ini
                        </h2>
                        <p class="panel__sub">Status diperbarui setiap kali halaman dimuat ulang.</p>
                    </div>
                    <span class="panel__count">{{ $myQueues->count() }}</span>
                </div>

                @if($myQueues->isEmpty())
                    <div class="empty-state">
                        <span class="empty-state__icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4Z"/><path d="M13 6v2M13 11v2M13 16v2"/></svg>
                        </span>
                        <strong>Belum ada tiket</strong>
                        <p>Pilih poli di samping untuk mengambil nomor antrean pertama Anda hari ini.</p>
                    </div>
                @else
                    <div class="ticket-list">
                        @foreach($myQueues as $queue)
                            @php
                                $badge = match ($queue->status) {
                                    'waiting' => ['badge-waiting', 'Menunggu'],
                                    'calling' => ['badge-calling', 'Dipanggil'],
                                    'completed' => ['badge-completed', 'Selesai'],
                                    default => ['badge-skipped', 'Dilewati'],
                                };
                            @endphp
                            <article class="ticket is-{{ $queue->status }}">
                                <div>
                                    <p class="ticket__service">{{ $queue->service->name }}</p>
                                    <div class="ticket__status">
                                        <span class="badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                                    </div>

                                    @if($queue->status === 'waiting')
                                        <p class="ticket__estimate">
                                            @if($queue->ahead_count === 0)
                                                <strong>Anda antrean berikutnya</strong> · menunggu panggilan
                                            @else
                                                <strong>~{{ $queue->estimation_minutes }} menit</strong>
                                                · {{ $queue->ahead_count }} antrean di depan Anda
                                            @endif
                                        </p>
                                    @elseif($queue->status === 'calling')
                                        <p class="ticket__estimate"><strong>Silakan masuk poli</strong> — nomor Anda sedang dipanggil.</p>
                                    @elseif($queue->status === 'completed')
                                        <p class="ticket__estimate">Kunjungan selesai. Semoga lekas sehat.</p>
                                    @else
                                        <p class="ticket__estimate">Nomor ini dilewati. Ambil tiket baru bila masih diperlukan.</p>
                                    @endif
                                </div>
                                <div class="ticket__number">{{ $queue->queue_number }}</div>
                            </article>
                        @endforeach
                    </div>
                @endif

                <p class="form-hint" style="margin-top: 1rem;">Tips: muat ulang halaman secara berkala agar estimasi tetap akurat.</p>
            </section>
        </div>
    </div>
@endsection
