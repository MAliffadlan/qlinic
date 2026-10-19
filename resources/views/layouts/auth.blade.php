<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0a3b2c">
    <title>@yield('title', 'Masuk — Qlinic')</title>
    <meta name="description" content="@yield('description', 'Masuk atau daftar akun Qlinic untuk mengambil nomor antrean klinik.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..600;1,9..144,400..600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/qlinic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body class="auth-body">
    <div class="auth-shell">
        <section class="auth-panel">
            <div class="auth-panel__top">
                <a class="brand" href="{{ route('landing') }}">
                    <span class="brand-mark"><img src="{{ asset('logo.png') }}" alt="Logo Qlinic"></span>
                    Qlinic
                </a>
                <a class="auth-panel__back" href="{{ route('landing') }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
                    Beranda
                </a>
            </div>

            <div class="auth-card">
                @yield('content')
            </div>
        </section>

        <aside class="auth-visual" aria-label="Tentang Qlinic">
            <div class="auth-visual__top">
                <a class="brand brand--light" href="{{ route('landing') }}">
                    <span class="brand-mark"><img src="{{ asset('logo.png') }}" alt=""></span>
                    Qlinic
                </a>
                <span class="auth-visual__tag">Sistem Antrian Klinik</span>
            </div>

            <div class="auth-visual__body">
                <p class="auth-visual__quote">Antre dari rumah.<br>Datang saat <em>giliran.</em></p>
                <p class="auth-visual__sub">Satu akun untuk mengambil nomor, memantau panggilan, dan datang tepat waktu tanpa menunggu lama.</p>

                <div class="auth-visual__steps">
                    <div class="auth-step">
                        <span class="auth-step__num">01</span>
                        <span>Daftar sekali dengan NIK 16 digit</span>
                    </div>
                    <div class="auth-step">
                        <span class="auth-step__num">02</span>
                        <span>Ambil nomor poli umum atau gigi</span>
                    </div>
                    <div class="auth-step">
                        <span class="auth-step__num">03</span>
                        <span>Pantau panggilan dari mana saja</span>
                    </div>
                </div>
            </div>

            <div class="auth-visual__footer">
                <span>&copy; {{ date('Y') }} Qlinic</span>
                <a href="{{ route('queue.display') }}">Lihat layar antrean →</a>
            </div>
        </aside>
    </div>

    <script src="{{ asset('js/qlinic.js') }}" defer></script>
    @yield('scripts')
</body>
</html>
