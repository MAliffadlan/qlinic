<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Qlinic - Sistem Layanan Mudah')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #059669; /* Soft Green */
            --primary-hover: #047857;
            --bg-color: #F8FAFC;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --white: #FFFFFF;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--white);
            height: 72px;
            padding: 0 5%;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .navbar-brand span {
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: var(--white);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .navbar-nav {
            display: flex;
            gap: 24px;
            list-style: none;
            align-items: center;
        }

        .navbar-nav a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 15px;
            transition: color 0.2s;
        }
        
        .navbar-nav a:hover {
            color: var(--primary);
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
            flex-grow: 1;
        }

        .card {
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            padding: 32px;
            transition: box-shadow 0.3s ease;
        }
        
        .card:hover {
            box-shadow: var(--shadow-md);
        }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: var(--text-main); }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s;
            background: #F8FAFC;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary { 
            background-color: var(--primary); 
            color: var(--white); 
            box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.2);
        }
        .btn-primary:hover { 
            background-color: var(--primary-hover); 
            transform: translateY(-1px);
            box-shadow: 0 6px 8px -1px rgba(5, 150, 105, 0.3);
        }
        .btn-block { width: 100%; }

        .auth-container { max-width: 440px; margin: 20px auto; }
        .text-center { text-align: center; }
        .mb-4 { margin-bottom: 24px; }
        .mb-2 { margin-bottom: 8px; }
        .mt-4 { margin-top: 24px; }
        .mt-2 { margin-top: 8px; }

        .btn-logout-nav {
            background: #F1F5F9;
            color: var(--text-main);
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout-nav:hover {
            background: #FEE2E2;
            color: #EF4444;
        }

        .alert { padding: 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 500; display: flex; align-items: center; gap: 12px;}
        .alert-success { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }
        .alert-error { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }
        
        .badge {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-warning { background: #FEF3C7; color: #B45309; }
        .badge-success { background: #D1FAE5; color: #047857; }
        .badge-info { background: #DBEAFE; color: #1D4ED8; }
        .badge-danger { background: #FEE2E2; color: #B91C1C; }

        .grid { display: grid; gap: 24px; }
        .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }

        @media (max-width: 768px) {
            .grid-cols-2 { grid-template-columns: 1fr; }
            .navbar { padding: 0 20px; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <header class="navbar">
        <a href="/" class="navbar-brand">
            <img src="{{ asset('logo.png') }}" alt="Logo" style="height: 32px; width: auto; object-fit: contain;"> Qlinic
        </a>
        <ul class="navbar-nav">
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}" style="color:var(--primary)">Daftar</a></li>
            @endguest
            @auth
                <li><span style="color: var(--text-main); font-weight: 600;">Halo, {{ explode(' ', Auth::user()->name)[0] }}</span></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-logout-nav">Logout</button>
                    </form>
                </li>
            @endauth
        </ul>
    </header>

    <main class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @yield('scripts')
</body>
</html>
