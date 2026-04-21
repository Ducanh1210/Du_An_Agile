<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PT Portal - EXTRA FIT+</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #FF6B35;
            --primary-dark: #E85A2A;
            --secondary: #2563EB;
            --bg: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-main: #1E293B;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --safe-bottom: env(safe-area-inset-bottom);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Be+Vietnam+Pro', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            line-height: 1.5;
            padding-bottom: calc(70px + var(--safe-bottom));
        }

        .header {
            background: var(--card-bg);
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border);
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .container {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Bottom Nav */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--card-bg);
            height: calc(65px + var(--safe-bottom));
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-top: 1px solid var(--border);
            padding-bottom: var(--safe-bottom);
            z-index: 1000;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .nav-item.active {
            color: var(--primary);
        }

        /* Common Components */
        .card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
        }

        .badge {
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-primary { background: #FFF1EB; color: var(--primary); }
        .badge-success { background: #ECFDF5; color: #10B981; }
        .badge-blue { background: #EFF6FF; color: var(--secondary); }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid var(--primary);
            color: var(--primary);
        }

        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #334155;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            z-index: 2000;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        @yield('styles')
    </style>
</head>
<body>

    <header class="header">
        <div class="header-title">PRO TRAINER</div>
        <a href="{{ route('trainer.profile') }}">
            <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=FF6B35&color=fff' }}" alt="Avatar" class="user-avatar">
        </a>
    </header>

    <main class="container">
        @if(session('success'))
            <div class="toast" id="successToast">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <nav class="bottom-nav">
        <a href="{{ route('trainer.dashboard') }}" class="nav-item {{ request()->routeIs('trainer.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Nhiệm vụ</span>
        </a>
        <a href="{{ route('trainer.schedule') }}" class="nav-item {{ request()->routeIs('trainer.schedule') ? 'active' : '' }}">
            <i class="fa-regular fa-calendar-days"></i>
            <span>Lịch</span>
        </a>
        <a href="{{ route('trainer.students') }}" class="nav-item {{ request()->routeIs('trainer.students*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-group"></i>
            <span>Học viên</span>
        </a>
        <a href="{{ route('trainer.profile') }}" class="nav-item {{ request()->routeIs('trainer.profile') ? 'active' : '' }}">
            <i class="fa-regular fa-user"></i>
            <span>Hồ sơ</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        <a href="#" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Thoát</span>
        </a>
    </nav>

    <script>
        // Auto hide toast
        const toast = document.getElementById('successToast');
        if (toast) {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s';
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }
    </script>
    @yield('scripts')
</body>
</html>
