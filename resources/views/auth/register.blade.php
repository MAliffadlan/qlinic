@extends('layouts.auth')

@section('title', 'Daftar Pasien — Qlinic')
@section('description', 'Buat akun Qlinic dengan NIK 16 digit dan ambil nomor antrean klinik dari rumah.')

@section('content')
    <div class="auth-card__head">
        <span class="eyebrow">Pendaftaran pasien</span>
        <h1 id="auth-title">Buat akun, ambil antrean.</h1>
        <p>Sekali daftar untuk semua kunjungan. Cukup NIK 16 digit, tanpa aplikasi tambahan.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-error" role="alert">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg>
            <span>Periksa kembali data Anda. Ada bagian yang perlu diperbaiki.</span>
        </div>
    @endif

    <form class="auth-form" action="{{ route('register') }}" method="POST">
        @csrf

        <div style="position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden;" aria-hidden="true">
            <label for="company">Company</label>
            <input type="text" id="company" name="company" tabindex="-1" autocomplete="off">
        </div>

        <div class="field">
            <label class="label" for="name">Nama lengkap</label>
            <input
                class="input"
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Sesuai KTP"
                autocomplete="name"
                required
                autofocus
            >
            @error('name')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="nik">NIK</label>
            <input
                class="input"
                type="text"
                id="nik"
                name="nik"
                value="{{ old('nik') }}"
                placeholder="16 digit sesuai KTP"
                inputmode="numeric"
                minlength="16"
                maxlength="16"
                pattern="\d{16}"
                autocomplete="off"
                data-nik-input
                required
            >
            <span class="form-hint" data-nik-counter>Masukkan 16 digit NIK sesuai KTP Anda.</span>
            @error('nik')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

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
            >
            @error('email')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-grid">
            <div class="field">
                <label class="label" for="password">Password</label>
                <div class="input-with-action">
                    <input
                        class="input"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Min. 8 karakter"
                        autocomplete="new-password"
                        required
                    >
                    <button class="input-action" type="button" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <label class="label" for="password_confirmation">Ulangi password</label>
                <div class="input-with-action">
                    <input
                        class="input"
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Tulis ulang"
                        autocomplete="new-password"
                        required
                    >
                    <button class="input-action" type="button" data-password-toggle="password_confirmation" aria-label="Tampilkan password" aria-pressed="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <button class="btn btn-primary btn-block btn-lg" type="submit">
            Buat akun pasien
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </button>

        <p class="form-hint" style="margin-top: 0.85rem; text-align: center;">
            Data Anda dipakai hanya untuk keperluan antrean klinik.
        </p>
    </form>

    <div class="auth-switch">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
@endsection
