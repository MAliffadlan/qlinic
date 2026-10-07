@extends('layouts.app')

@section('title', 'Login - Qlinic')

@section('content')
<div class="auth-container">
    <div class="card" style="padding: 40px; border-top: 6px solid var(--primary); box-shadow: var(--shadow-lg);">
        
        <div class="text-center mb-4">
            <h2 style="font-size: 28px; font-weight: 800; color: var(--primary); margin-bottom: 8px;">Selamat Datang</h2>
            <p style="color: var(--text-muted); font-size: 15px;">Masuk untuk mengambil nomor antrean</p>
        </div>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="masukkan email anda" required autofocus>
            </div>

            <div class="form-group" style="margin-bottom: 32px;">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="padding: 14px; font-size: 16px;">Masuk Aplikasi</button>
        </form>

        <div style="margin-top: 24px; background: #F8FAFC; padding: 20px; border-radius: 12px; border: 1px solid var(--border-color);">
            <p style="font-size: 13px; font-weight: 700; color: var(--primary); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Akses Akun Demo</p>
            
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 2px;">Sebagai Admin:</p>
                    <p style="font-size: 14px; font-weight: 600; color: var(--text-main);">admin@qlinic.com / <span style="font-weight: 400;">password</span></p>
                </div>
                <div>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 2px;">Sebagai Pasien:</p>
                    <p style="font-size: 14px; font-weight: 600; color: var(--text-main);">patient01@qlinic.com / <span style="font-weight: 400;">password</span></p>
                </div>
            </div>
        </div>

        <div style="margin-top: 32px; text-align: center; border-top: 1px solid var(--border-color); padding-top: 24px;">
            <p style="color: var(--text-muted); font-size: 15px;">
                Pasien Kunjungan Baru? <br>
                <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 700; display: inline-block; margin-top: 8px;">Daftar Akun Sekarang &rarr;</a>
            </p>
        </div>
    </div>
</div>
@endsection
