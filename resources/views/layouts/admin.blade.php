<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#fffdf8">
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
    <noscript><style>
        @media (max-width: 1024px) {
            .admin-sidebar { position: static; width: 100%; height: auto; transform: none; box-sizing: border-box; }
            .admin-main { min-width: 0; }
            .admin-sidebar__close, .admin-backdrop, .admin-menu-btn { display: none; }
            .admin-sidebar__spacer { min-height: 24px; }
        }
        .admin-notifications { position: static; width: auto; margin: 0 24px 24px; }
        .admin-toast__close { display: none; }
    </style></noscript>

    <aside class="admin-sidebar" id="admin-navigation" aria-label="Navigasi admin">
        <div class="admin-sidebar__brand">
            <a class="brand" href="{{ route('admin.dashboard') }}">
                <span class="brand-mark"><img src="{{ asset('logo.png') }}" alt="Logo Qlinic"></span>
                Qlinic
            </a>
            <button class="admin-sidebar__close" type="button" data-sidebar-close aria-label="Tutup navigasi admin">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="admin-nav" aria-label="Menu admin">
            <a class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                <span class="admin-nav__index" aria-hidden="true">01</span>
                <span>Dashboard</span>
            </a>
            <a class="admin-nav__link {{ request()->routeIs('admin.display') ? 'is-active' : '' }}" href="{{ route('admin.display') }}" @if(request()->routeIs('admin.display')) aria-current="page" @endif>
                <span class="admin-nav__index" aria-hidden="true">02</span>
                <span>Layar TV</span>
            </a>
            <a class="admin-nav__link" href="{{ route('queue.display') }}" target="_blank" rel="noopener" aria-label="Layar TV Publik, buka di tab baru">
                <span class="admin-nav__index" aria-hidden="true">03</span>
                <span>Layar TV Publik</span>
            </a>
        </nav>

        <div class="admin-sidebar__spacer"></div>

        <div class="admin-user">
            <div class="admin-user__meta">
                <div class="admin-user__name">{{ Auth::user()->name }}</div>
                <div class="admin-user__role">Administrator</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="admin-logout" type="submit">Keluar</button>
            </form>
        </div>
    </aside>

    <button class="admin-backdrop" type="button" data-sidebar-close aria-label="Tutup navigasi admin" tabindex="-1"></button>

    <div class="admin-main">
        <header class="admin-topbar">
            <button class="admin-menu-btn js-sidebar-open" type="button" aria-label="Buka navigasi admin" aria-controls="admin-navigation" aria-expanded="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>

            <div class="admin-topbar__title">
                <strong>@yield('title_header', 'Manajemen Antrean')</strong>
                <span>@yield('subtitle_header', 'Pantau dan kendalikan panggilan poli hari ini.')</span>
            </div>

            <div class="admin-topbar__actions">
                <span class="admin-topbar__date">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 11h18"/></svg>
                    {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </header>

        <main class="admin-content" id="konten" tabindex="-1">
            @yield('content')
        </main>
    </div>

    @if(session('success') || session('error'))
        <div class="admin-notifications" id="admin-notifications" aria-label="Notifikasi dashboard">
            @if(session('success'))
                <div class="admin-toast admin-toast--success" role="status" data-admin-toast>
                    <svg class="admin-toast__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                    <span class="admin-toast__message">{{ session('success') }}</span>
                    <button class="admin-toast__close" type="button" data-toast-dismiss aria-label="Tutup notifikasi">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="admin-toast admin-toast--error" role="alert" data-admin-toast>
                    <svg class="admin-toast__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg>
                    <span class="admin-toast__message">{{ session('error') }}</span>
                    <button class="admin-toast__close" type="button" data-toast-dismiss aria-label="Tutup notifikasi">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
        </div>
    @endif

    <script src="{{ asset('js/admin-sidebar.js') }}" defer></script>
    <script src="{{ asset('js/admin-toast.js') }}" defer></script>
    @yield('scripts')
</body>
</html>
