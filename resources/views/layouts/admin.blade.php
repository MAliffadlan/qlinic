<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Qlinic')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #059669; /* Soft Green */
            --primary-hover: #047857;
            --bg-color: #F8FAFC;
            --sidebar-bg: #FFFFFF;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --danger: #EF4444;
            --success: #10B981;
            --warning: #F59E0B;
            --white: #FFFFFF;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius-md: 12px;
            --radius-lg: 16px;
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
            display: flex;
            height: 100vh;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .sidebar-brand {
            padding: 24px;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-brand span {
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

        .sidebar-nav {
            flex-grow: 1;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item {
            padding: 12px 16px;
            border-radius: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-item:hover {
            background-color: #F1F5F9;
            color: var(--primary);
        }

        .nav-item.active {
            background-color: var(--primary);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--border-color);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: #E2E8F0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--primary);
        }

        .user-info .name {
            font-weight: 600;
            font-size: 14px;
        }
        
        .user-info .role {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: capitalize;
        }

        /* Main Content Styles */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            height: 72px;
            background-color: var(--white);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
        }

        .content-area {
            flex-grow: 1;
            padding: 32px;
            overflow-y: auto;
        }

        /* Utilities */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            font-size: 14px;
            text-decoration: none;
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

        .btn-danger { background-color: #FEF2F2; color: var(--danger); border: 1px solid #FCA5A5;}
        .btn-danger:hover { background-color: var(--danger); color: white; }

        .btn-success { background-color: #ECFDF5; color: var(--success); border: 1px solid #6EE7B7; }
        .btn-success:hover { background-color: var(--success); color: white; }

        .btn-outline {
            border: 1px solid var(--border-color);
            background: var(--white);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: #F8FAFC;
        }

        .card {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            padding: 24px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

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
        .grid-cols-3 { grid-template-columns: repeat(3, 1fr); }

        .form-logout { width: 100%; }
        .btn-logout { 
            width: 100%; 
            padding: 10px; 
            border-radius: 8px; 
            background: #F1F5F9; 
            color: var(--text-main);
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: #E2E8F0; color: var(--danger); }

        .d-flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .items-center { align-items: center; }
        .mb-4 { margin-bottom: 24px; }
        .mb-2 { margin-bottom: 8px; }
        .mt-4 { margin-top: 24px; }
        .text-center { text-align: center; }
        
        /* Table Styles */
        .table-responsive { overflow-x: auto; }
        .table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .table th { background: #F8FAFC; text-align: left; padding: 16px; font-weight: 600; color: var(--text-muted); font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--border-color); border-top: 1px solid var(--border-color); }
        .table td { padding: 16px; border-bottom: 1px solid var(--border-color); font-size: 14px; }
        .table tr:first-child th:first-child { border-top-left-radius: 8px; border-left: 1px solid var(--border-color); }
        .table tr:first-child th:last-child { border-top-right-radius: 8px; border-right: 1px solid var(--border-color); }
        .table tr td:first-child { border-left: 1px solid var(--border-color); }
        .table tr td:last-child { border-right: 1px solid var(--border-color); }
        .table tr:last-child td:first-child { border-bottom-left-radius: 8px; }
        .table tr:last-child td:last-child { border-bottom-right-radius: 8px; }
        .table tbody tr:hover td { background-color: #F8FAFC; }

        /* Alert */
        .alert { padding: 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 500; display: flex; align-items: center; gap: 12px;}
        .alert-success { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }
        .alert-error { background: #FEF2F2; color: #B91C1C; border: 1px solid #FECACA; }
    </style>
    @yield('styles')
</head>
<body>
    <aside class="sidebar">
        <a href="/" class="sidebar-brand">
            <img src="{{ asset('logo.png') }}" alt="Logo" style="height: 32px; width: auto; object-fit: contain;"> Qlinic
        </a>
        
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('queue.display') }}" target="_blank" class="nav-item">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Buka Layar TV
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="user-info">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">{{ Auth::user()->role }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="form-logout">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-title">@yield('title_header', 'Manajemen Antrian')</div>
            <div style="color: var(--text-muted); font-size: 14px;">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </header>

        <main class="content-area">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @yield('scripts')
</body>
</html>
