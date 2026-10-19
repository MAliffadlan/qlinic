@extends('layouts.auth')

@section('title', 'Masuk — Qlinic')
@section('description', 'Masuk ke akun Qlinic untuk mengambil nomor antrean klinik dan memantau panggilan.')

@section('content')
    <div class="auth-card__head">
        <span class="eyebrow">Akun pasien</span>
        <h1 id="auth-title">Selamat datang kembali.</h1>
        <p>Masuk untuk mengambil nomor dan memantau antrean hari ini.</p>
    </div>

    <form class="auth-form" action="{{ route('login') }}" method="POST">
        @csrf

        <div class="field">
            <label class="label" for="email">Alamat email</label>
            <input
                class="input"
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                autocomplete="email"
                required
                autofocus
                @error('email') aria-invalid="true" @enderror
            >
            @error('email')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password">Password</label>
            <div class="input-with-action">
                <input
                    class="input"
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >
                <button class="input-action" type="button" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>

        <button class="btn btn-primary btn-block btn-lg" type="submit">
            Masuk ke Qlinic
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </button>
    </form>

    <div class="auth-switch">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai pasien</a>
    </div>

    @if(app()->environment('local'))
        <div class="demo-box" aria-label="Akun demo untuk lingkungan lokal">
            <div class="demo-box__label">Akun demo · hanya lokal</div>
            <div class="demo-box__row">
                <span>Admin</span>
                <code>admin@klinik.com / password</code>
            </div>
            <div class="demo-box__row">
                <span>Pasien</span>
                <code>patient01@qlinic.com / password</code>
            </div>
        </div>
    @endif
@endsection
