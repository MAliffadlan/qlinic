<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#07271d">
    <title>@yield('title', 'Admin — Qlinic')</title>
    <meta name="description" content="Ruang kerja petugas klinik Qlinic.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..600;1,9..144,400..600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/qlinic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('styles')
</head>
<body class="admin-body">
    <a class="skip-link" href="#konten">Lewati ke konten</a>

    <aside class="admin-sidebar" aria-label="Navigasi admin">
        <div class="admin-sidebar__brand">
            <a class="brand brand--light" href="{{ route('admin.dashboard') }}">
                <span class="brand-mark"><img src="{{ asset('logo.png') }}" alt="Logo Qlinic"></span>
                Qlinic
            </a>
            <button class="admin-sidebar__close" type="button" data-sidebar-toggle aria-label="Tutup menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <p class="admin-sidebar__label">Ruang kerja</p>
        <nav class="admin-nav">
            <a class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9h13v-9"/><path d="M9.5 19v-5h5v5"/></svg>
                Dashboard
            </a>
            <a class="admin-nav__link" href="{{ route('queue.display') }}" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                Layar TV
                <svg style="margin-left:auto; width:14px; height:14px; opacity:.5;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M9 7h8v8"/></svg>
            </a>
        </nav>

        <div class="admin-sidebar__spacer"></div>

        <div class="admin-sidebar__note">
            <strong>Layar antrean publik</strong>
            <p>Buka layar TV di perangkat terpisah agar pasien dapat melihat panggilan secara langsung.</p>
        </div>

        <div class="admin-user">
            <span class="avatar" aria-hidden="true">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
            <div class="admin-user__meta">
                <div class="admin-user__name">{{ Auth::user()->name }}</div>
                <div class="admin-user__role">Petugas</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="admin-logout" type="submit" aria-label="Keluar dari akun" title="Keluar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 17l5-5-5-5"/><path d="M20 12H9"/><path d="M12 19H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-backdrop" data-sidebar-toggle aria-hidden="true"></div>

    <div class="admin-main">
        <header class="admin-topbar">
            <button class="admin-menu-btn" type="button" data-sidebar-toggle aria-label="Buka menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>

            <div class="admin-topbar__title">
                <strong>@yield('title_header', 'Manajemen Antrean')</strong>
                <span>Pantau dan kendalikan panggilan poli hari ini.</span>
            </div>

            <div class="admin-topbar__actions">
                <span class="admin-topbar__date">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 11h18"/></svg>
                    {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}
                </span>
                <a class="btn btn-outline btn-sm" href="{{ route('queue.display') }}" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    <span>Buka layar TV</span>
                </a>
            </div>
        </header>

        <main class="admin-content" id="konten">
            @if(session('success'))
                <div class="alert alert-success" role="status">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error" role="alert">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/qlinic.js') }}" defer></script>
    @yield('scripts')
</body>
</html>
