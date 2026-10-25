@extends('layouts.admin')

@section('title', 'Layar TV Admin — Qlinic')
@section('title_header', 'Layar TV')
@section('subtitle_header', 'Pantau panggilan poli tanpa meninggalkan dashboard.')

@section('content')
    <section class="admin-tv" aria-labelledby="admin-tv-title">
        <header class="admin-tv__intro">
            <div>
                <h1 id="admin-tv-title">Antrean saat ini</h1>
                <p>Pantau panggilan pasien tanpa meninggalkan dashboard.</p>
            </div>
            <span class="admin-tv__connection" id="admin-tv-connection" role="status">Live</span>
        </header>

        <div class="admin-tv__services" id="admin-tv-services" data-status-url="{{ route('queue.api.status') }}"></div>
        <p class="sr-only" id="admin-tv-announcer" role="status" aria-live="polite" aria-atomic="true"></p>

        <noscript>
            <p class="admin-tv__fallback">Aktifkan JavaScript untuk menampilkan antrean secara langsung. <a href="{{ route('queue.display') }}">Buka layar TV publik</a>.</p>
        </noscript>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin-tv.js') }}" defer></script>
@endsection
