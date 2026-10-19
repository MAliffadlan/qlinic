<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0a3b2c">
    <title>@yield('title', 'Qlinic — Antrian Klinik')</title>
    <meta name="description" content="@yield('description', 'Ambil nomor antrean klinik dari rumah dan pantau panggilan secara real-time.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..600;1,9..144,400..600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/qlinic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body class="app-body">
    <a class="skip-link" href="#konten">Lewati ke konten</a>

    <header class="site-header">
        <div class="container site-nav">
            <a class="brand" href="{{ route('landing') }}">
                <span class="brand-mark"><img src="{{ asset('logo.png') }}" alt="Logo Qlinic"></span>
                Qlinic
            </a>

            <nav class="site-nav__links" aria-label="Navigasi utama">
                <a class="nav-link {{ request()->routeIs('patient.dashboard') ? 'is-active' : '' }}" href="{{ route('patient.dashboard') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9h13v-9"/><path d="M9.5 19v-5h5v5"/></svg>
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('queue.display') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    Layar Antrean
                </a>
            </nav>

            <div class="site-nav__user">
                <span class="avatar" aria-hidden="true">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                <span class="nav-user__meta">
                    <span class="nav-user__name">{{ explode(' ', trim(Auth::user()->name))[0] }}</span>
                    <span class="nav-user__role">{{ Auth::user()->role === 'admin' ? 'Petugas' : 'Akun pasien' }}</span>
                </span>
                <form class="nav-logout" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-icon btn-ghost" aria-label="Keluar dari akun" title="Keluar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 17l5-5-5-5"/><path d="M20 12H9"/><path d="M12 19H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="page-main" id="konten">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success" role="status" style="margin-top: 24px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error" role="alert" style="margin-top: 24px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="app-footer">
        <div class="container app-footer__inner">
            <span><strong style="color: var(--ink-soft);">Qlinic</strong> — antrian klinik yang lebih tenang.</span>
            <span>
                <a href="{{ route('landing') }}">Beranda</a>
                &nbsp;·&nbsp;
                <a href="{{ route('queue.display') }}">Layar antrean</a>
            </span>
        </div>
    </footer>

    <script src="{{ asset('js/qlinic.js') }}" defer></script>
    @yield('scripts')
</body>
</html>
