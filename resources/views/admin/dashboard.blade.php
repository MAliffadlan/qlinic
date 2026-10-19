@extends('layouts.admin')

@section('title', 'Dashboard Admin — Qlinic')
@section('title_header', 'Ikhtisar Layanan')

@section('content')
    @php
        $totalToday = $queues->count();
        $waitingTotal = $queues->where('status', 'waiting')->count();
        $callingTotal = $queues->where('status', 'calling')->count();
        $completedTotal = $queues->where('status', 'completed')->count();
        $now = \Carbon\Carbon::now('Asia/Jakarta');
    @endphp

    <header class="admin-heading">
        <div>
            <span class="eyebrow">Ikhtisar hari ini</span>
            <h1>Antrean yang <em>terkendali.</em></h1>
            <p>Pantau panggilan aktif, selesaikan layanan, dan panggil pasien berikutnya.</p>
        </div>
    </header>

    <div class="stat-grid">
        <article class="stat-card">
            <span class="stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </span>
            <div>
                <div class="stat-card__label">Total tiket</div>
                <div class="stat-card__value">{{ $totalToday }} <small>tiket hari ini</small></div>
            </div>
        </article>

        <article class="stat-card">
            <span class="stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
            </span>
            <div>
                <div class="stat-card__label">Menunggu</div>
                <div class="stat-card__value">{{ $waitingTotal }} <small>pasien</small></div>
            </div>
        </article>

        <article class="stat-card">
            <span class="stat-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
            </span>
            <div>
                <div class="stat-card__label">Selesai</div>
                <div class="stat-card__value">{{ $completedTotal }} <small>dari {{ $totalToday }} tiket</small></div>
            </div>
        </article>
    </div>

    <div class="control-grid">
        @foreach($services as $service)
            @php
                $serviceQueues = $queues->where('service_id', $service->id);
                $calling = $serviceQueues->where('status', 'calling')->first();
                $waiting = $serviceQueues->where('status', 'waiting')->count();
            @endphp

            <article class="control-card">
                <div class="control-card__head">
                    <div class="control-card__service">
                        <span class="control-card__code">{{ $service->code }}</span>
                        <div>
                            <h2 class="control-card__name">{{ $service->name }}</h2>
                            <p class="control-card__sub">{{ $waiting }} menunggu · {{ $calling ? 'sedang melayani' : 'siap melayani' }}</p>
                        </div>
                    </div>
                    <span class="control-card__live {{ $calling ? '' : 'is-idle' }}">
                        {{ $calling ? 'Sedang dipanggil' : 'Kosong' }}
                    </span>
                </div>

                <div class="control-card__stage {{ $calling ? '' : 'is-empty' }}">
                    <div class="control-card__stage-label">
                        <span>Sedang dilayani</span>
                        <span>{{ $calling ? 'Poli ' . $service->code : 'Belum ada' }}</span>
                    </div>
                    @if($calling)
                        <div class="control-card__number">{{ $calling->queue_number }}</div>
                    @else
                        <div class="control-card__idle">Kosong</div>
                    @endif
                    <div class="control-card__patient">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                        {{ $calling?->user?->name ?? 'Menunggu panggilan berikutnya' }}
                    </div>

                    @if($calling)
                        <div class="control-card__actions">
                            <form action="{{ route('admin.queue.update', $calling->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button class="btn btn-success" type="submit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                    Selesai
                                </button>
                            </form>
                            <form action="{{ route('admin.queue.update', $calling->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="skipped">
                                <button class="btn btn-danger" type="submit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                    Lewati
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="control-card__foot">
                    <span class="control-card__waiting"><strong>{{ $waiting }}</strong> antrean menunggu</span>
                    <form action="{{ route('admin.queue.next') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <button class="btn btn-primary" type="submit" {{ $waiting === 0 ? 'disabled' : '' }} title="{{ $waiting === 0 ? 'Belum ada antrean menunggu' : 'Panggil antrean berikutnya' }}">
                            Panggil berikutnya
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </button>
                    </form>
                </div>
            </article>
        @endforeach
    </div>

    <section class="table-panel" aria-labelledby="daftar-antrean">
        <div class="table-toolbar">
            <h2 class="table-toolbar__title" id="daftar-antrean">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 6h13M8 12h13M8 18h13"/><path d="M3 6h.01M3 12h.01M3 18h.01"/></svg>
                Daftar antrean hari ini
            </h2>

            <div class="filter-tabs" role="group" aria-label="Filter status antrean">
                <button class="filter-tab is-active" type="button" data-filter="all" aria-pressed="true">Semua</button>
                <button class="filter-tab" type="button" data-filter="waiting" aria-pressed="false">Menunggu</button>
                <button class="filter-tab" type="button" data-filter="calling" aria-pressed="false">Dipanggil</button>
                <button class="filter-tab" type="button" data-filter="completed" aria-pressed="false">Selesai</button>
                <button class="filter-tab" type="button" data-filter="skipped" aria-pressed="false">Dilewati</button>
            </div>
        </div>

        <div class="table-scroll">
            <table class="queue-table">
                <thead>
                    <tr>
                        <th scope="col">No. antrean</th>
                        <th scope="col">Pasien</th>
                        <th scope="col">Layanan</th>
                        <th scope="col">Diambil</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($queues as $item)
                        @php
                            $badge = match ($item->status) {
                                'waiting' => ['badge-waiting', 'Menunggu'],
                                'calling' => ['badge-calling', 'Dipanggil'],
                                'completed' => ['badge-completed', 'Selesai'],
                                'skipped' => ['badge-skipped', 'Dilewati'],
                                default => ['badge-skipped', $item->status],
                            };
                        @endphp
                        <tr data-queue-row data-status="{{ $item->status }}">
                            <td><span class="queue-table__number">{{ $item->queue_number }}</span></td>
                            <td>
                                <span class="queue-table__patient">
                                    <span class="avatar" aria-hidden="true">{{ mb_substr($item->user->name, 0, 1) }}</span>
                                    {{ $item->user->name }}
                                </span>
                            </td>
                            <td>{{ $item->service->name }}</td>
                            <td><span class="queue-table__time">{{ $item->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</span></td>
                            <td><span class="badge {{ $badge[0] }}">{{ $badge[1] }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td class="queue-table__empty" colspan="5">Belum ada antrean yang diambil hari ini.</td>
                        </tr>
                    @endforelse
                    <tr id="filter-empty" hidden>
                        <td class="queue-table__empty" colspan="5">Tidak ada antrean dengan status ini.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-footnote">
            <span>{{ $totalToday }} tiket tercatat hari ini · {{ $callingTotal }} sedang dipanggil</span>
            <span>Diperbarui {{ $now->format('H:i') }} WIB</span>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        (function () {
            var tabs = document.querySelectorAll("[data-filter]");
            var rows = document.querySelectorAll("[data-queue-row]");
            var emptyRow = document.getElementById("filter-empty");

            tabs.forEach(function (tab) {
                tab.addEventListener("click", function () {
                    var filter = tab.getAttribute("data-filter");
                    var visible = 0;

                    tabs.forEach(function (item) {
                        var active = item === tab;
                        item.classList.toggle("is-active", active);
                        item.setAttribute("aria-pressed", String(active));
                    });

                    rows.forEach(function (row) {
                        var show = filter === "all" || row.getAttribute("data-status") === filter;
                        row.hidden = !show;
                        if (show) visible += 1;
                    });

                    if (emptyRow) {
                        emptyRow.hidden = visible > 0 || rows.length === 0;
                    }
                });
            });
        })();
    </script>
@endsection
