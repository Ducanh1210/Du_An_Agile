<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trainer Dashboard - EXTRA FIT+')</title>
    
    <!-- Google Fonts: Be Vietnam Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #FF6B35;
            --primary-light: #FFF1EB;
            --secondary: #2563EB;
            --bg: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --header-h: 72px;
            --sidebar-w: 260px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --radius: 16px;
        }

        [data-theme="dark"] {
            --bg: #0F172A;
            --card-bg: #1E293B;
            --text-main: #F8FAFC;
            --text-muted: #94A3B8;
            --border: #334155;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--card-bg);
            border-right: 1px solid var(--border);
            height: 100vh;
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            height: var(--header-h);
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid var(--border);
        }

        .logo-img { height: 32px; }

        .sidebar-nav {
            padding: 24px 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }

        .nav-link i { font-size: 18px; width: 24px; text-align: center; }

        .nav-link:hover {
            background: var(--bg);
            color: var(--primary);
        }

        .nav-link.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--border);
        }

        /* Main Content */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .top-header {
            height: var(--header-h);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 32px;
            gap: 24px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 6px;
            border-radius: 100px;
            transition: background 0.2s;
        }

        .user-profile:hover { background: var(--bg); }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .user-info { line-height: 1.2; }
        .user-name { font-weight: 700; font-size: 14px; display: block; }
        .user-role { font-size: 11px; color: var(--text-muted); font-weight: 500; }

        .content-body {
            padding: 32px;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }

        /* Common Components */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            margin-bottom: 24px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }

        .btn-outline { background: transparent; border: 1.5px solid var(--border); color: var(--text-muted); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }

        /* Mobile Header */
        .mobile-header {
            display: none;
            height: 60px;
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            padding: 0 20px;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1100;
        }

        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                left: -100%;
                top: 0;
            }
            .sidebar.open { left: 0; }
            .mobile-header { display: flex; }
            .top-header { display: none; }
            .content-body { padding: 20px; }
        }

        @yield('styles')
    </style>
</head>
<body x-data="{ sidebarOpen: false }">

    <!-- Sidebar -->
    <aside class="sidebar" :class="sidebarOpen ? 'open' : ''">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('trainer.dashboard') }}" class="nav-link {{ request()->routeIs('trainer.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-grid-2"></i>
                <span>Tổng quan</span>
            </a>
            <a href="{{ route('trainer.students') }}" class="nav-link {{ request()->routeIs('trainer.students*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Học viên</span>
            </a>
            <a href="{{ route('trainer.schedule') }}" class="nav-link {{ request()->routeIs('trainer.schedule') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-alt"></i>
                <span>Lịch dạy</span>
            </a>
            <div style="margin-top: 20px; padding: 0 16px; font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Hệ thống</div>
            <a href="{{ url('/') }}" class="nav-link">
                <i class="fa-solid fa-house"></i>
                <span>Trang Client</span>
            </a>
            <a href="{{ route('trainer.profile') }}" class="nav-link {{ request()->routeIs('trainer.profile') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i>
                <span>Hồ sơ cá nhân</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('logout.get') }}" class="nav-link" style="color: #EF4444;">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Đăng xuất</span>
            </a>
        </div>
    </aside>

    <!-- Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-[950] lg:hidden" style="display: none;"></div>

    <div class="main-wrapper">
        <!-- Mobile Header -->
        <header class="mobile-header">
            <button @click="sidebarOpen = true" style="background: none; border: none; font-size: 20px; color: var(--text-main);">
                <i class="fa-solid fa-bars"></i>
            </button>
            <img src="{{ asset('images/logo.png') }}" style="height: 24px;">
            <div style="width: 20px;"></div>
        </header>

        <!-- Top Header -->
        <header class="top-header">
            @include('layouts.partials._notifications')
            
            <div class="user-profile" onclick="window.location='{{ route('trainer.profile') }}'">
                <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=FF6B35&color=fff' }}" alt="Avatar" class="user-avatar">
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-role">Huấn luyện viên</span>
                </div>
                <i class="fa-solid fa-chevron-down" style="font-size: 10px; opacity: 0.5;"></i>
            </div>
        </header>

        <main class="content-body">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
