@extends('layouts.app')

@section('title', 'Daftar Antrean - Qlinic')

@section('content')
<div class="auth-container" style="max-width: 500px;">
    <div class="card" style="padding: 40px; border-top: 6px solid var(--primary); box-shadow: var(--shadow-lg);">
        
        <div class="text-center mb-4">
            <h2 style="font-size: 28px; font-weight: 800; color: var(--primary); margin-bottom: 8px;">Pendaftaran Akun</h2>
            <p style="color: var(--text-muted); font-size: 15px;">Mohon isi rekam identitas Anda dengan benar</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="nik" class="form-label">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" id="nik" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="16 digit NIK Anda" required autofocus>
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap Pasien</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Sesuai dengan KTP" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email Aktif</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="contoh@gmail.com" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Buat Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 32px;">
                <label for="password_confirmation" class="form-label">Ulangi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Tulis kembali password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="padding: 14px; font-size: 16px;">Buat Akun Pasien</button>
        </form>

        <div style="margin-top: 32px; text-align: center; border-top: 1px solid var(--border-color); padding-top: 24px;">
            <p style="color: var(--text-muted); font-size: 15px;">
                Sudah pernah mendaftar?  <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 700;">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
