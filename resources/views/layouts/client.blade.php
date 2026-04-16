<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EXTRA FIT+ GYM & FITNESS - Trung tâm thể hình hàng đầu. Huấn luyện viên chuyên nghiệp, lớp học đa dạng, cơ sở vật chất hiện đại.">
    <title>@yield('title', 'EXTRA FIT+ GYM & FITNESS')</title>

    <!-- Google Fonts: Be Vietnam Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Design System CSS -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">

    @yield('styles')
</head>
<body>

{{-- ============================== HEADER ============================== --}}
<header class="site-header" id="siteHeader">
    <div class="header-container">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="header-logo" id="headerLogo">
            <img src="{{ asset('images/logo.png') }}" alt="EXTRA FIT+ GYM & FITNESS Logo" class="logo-img">
        </a>

        {{-- Nav Desktop --}}
        <nav class="header-nav" id="headerNav">
            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Trang chủ</a>
            <a href="{{ url('/huan-luyen-vien') }}" class="nav-link {{ request()->is('huan-luyen-vien*') ? 'active' : '' }}">Huấn luyện viên</a>
            <a href="{{ url('/lich-lop') }}" class="nav-link {{ request()->is('lich-lop*') ? 'active' : '' }}">Lịch lớp</a>
            <a href="{{ route('client.memberships') }}" class="nav-link {{ request()->is('goi-tap*') ? 'active' : '' }}">Gói tập</a>
            <a href="{{ url('/tin-tuc') }}" class="nav-link {{ request()->is('tin-tuc*') ? 'active' : '' }}">Tin tức</a>
            <a href="{{ url('/lien-he') }}" class="nav-link {{ request()->is('lien-he*') ? 'active' : '' }}">Liên hệ</a>
        </nav>

        {{-- Header Actions --}}
        <div class="header-actions">

            {{-- Notification Bell --}}
            <button class="header-icon-btn" id="notificationBtn" title="Thông báo" aria-label="Thông báo">
                <i class="fas fa-bell"></i>
                <span class="badge-count" id="notifCount">3</span>
            </button>

            {{-- Dark Mode Toggle --}}
            <button class="header-icon-btn dark-toggle" id="darkModeToggle" title="Đổi giao diện" aria-label="Chế độ tối">
                <i class="fas fa-moon" id="darkIcon"></i>
            </button>

            {{-- Login/Register (hiện khi chưa đăng nhập) --}}
            @guest
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Đăng nhập</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Đăng ký</a>
            </div>
            @endguest

            {{-- User Dropdown (hiện khi đã đăng nhập) --}}
            @auth
            <div class="user-dropdown" id="userDropdown">
                <button class="user-trigger" id="userTrigger">
                    <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=FF6B35&color=fff&size=36' }}" alt="Avatar" class="user-avatar">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down user-chevron"></i>
                </button>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="{{ url('/ho-so') }}" class="dropdown-item"><i class="fas fa-user"></i> Hồ sơ</a>
                    <a href="{{ url('/goi-dang-ky') }}" class="dropdown-item"><i class="fas fa-star"></i> Gói đã đăng ký</a>
                    <a href="{{ url('/lich-ca-nhan') }}" class="dropdown-item"><i class="fas fa-calendar"></i> Lịch cá nhân</a>
                    <a href="{{ route('client.payment_history') }}" class="dropdown-item"><i class="fas fa-receipt"></i> Lịch sử thanh toán</a>
                    <a href="{{ url('/check-in') }}" class="dropdown-item"><i class="fas fa-qrcode"></i> Check-in QR</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item dropdown-logout" style="border: none; background: none; width: 100%; text-align: left;"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
                    </form>
                </div>
            </div>
            @endauth

            {{-- Mobile Hamburger --}}
            <button class="hamburger-btn" id="hamburgerBtn" aria-label="Menu" aria-expanded="false">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>
    </div>
</header>

{{-- Mobile Drawer --}}
<div class="drawer-overlay" id="drawerOverlay"></div>
<aside class="mobile-drawer" id="mobileDrawer">
    <div class="drawer-header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="drawer-logo">
        <button class="drawer-close" id="drawerClose" aria-label="Đóng menu">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <nav class="drawer-nav">
        <a href="{{ url('/') }}" class="drawer-link {{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-home"></i> Trang chủ</a>
        <a href="{{ url('/huan-luyen-vien') }}" class="drawer-link"><i class="fas fa-dumbbell"></i> Huấn luyện viên</a>
        <a href="{{ url('/lich-lop') }}" class="drawer-link"><i class="fas fa-calendar-alt"></i> Lịch lớp</a>
        <a href="{{ route('client.memberships') }}" class="drawer-link"><i class="fas fa-tags"></i> Gói tập</a>
        <a href="{{ url('/tin-tuc') }}" class="drawer-link"><i class="fas fa-newspaper"></i> Tin tức</a>
        <a href="{{ url('/lien-he') }}" class="drawer-link"><i class="fas fa-envelope"></i> Liên hệ</a>
    </nav>
    <div class="drawer-footer">
        @auth
        <div class="drawer-user">
            <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=FF6B35&color=fff&size=40' }}" alt="Avatar" class="drawer-avatar">
            <div class="min-w-0">
                <div class="drawer-user-name truncate">{{ auth()->user()->name }}</div>
                <div class="drawer-user-email truncate">{{ auth()->user()->email }}</div>
            </div>
        </div>
        @endauth
        <button class="btn btn-outline-primary w-full" id="drawerDarkToggle">
            <i class="fas fa-moon" id="drawerDarkIcon"></i> Chế độ tối
        </button>
    </div>
</aside>

{{-- Header Spacer --}}
<div class="header-spacer"></div>

{{-- Breadcrumb --}}
@hasSection('breadcrumb')
<div class="breadcrumb-wrapper">
    <div class="container">
        @yield('breadcrumb')
    </div>
</div>
@endif

{{-- Main Content --}}
<main class="site-main">
    @yield('content')
</main>

{{-- ============================== FOOTER ============================== --}}
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">

            {{-- Col 1: Brand --}}
            <div class="footer-col">
                @php
                    $fallbackLogo = asset('images/logo.png');
                @endphp
                <img src="{{ asset('images/logo-white.png') }}" alt="EXTRA FIT+" class="footer-logo" onerror="this.onerror=null; this.src='{{ $fallbackLogo }}'; this.style.filter='brightness(0) invert(1)';">
                <p class="footer-desc">Nơi bạn bắt đầu hành trình thay đổi bản thân. Huấn luyện chuyên nghiệp, cơ sở hiện đại, cộng đồng năng động.</p>
                <div class="social-links">
                    <a href="#" class="social-link" title="Facebook" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" title="Instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" title="YouTube" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-link" title="TikTok" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            {{-- Col 2: Quick Nav --}}
            <div class="footer-col">
                <h4 class="footer-title">Điều hướng</h4>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li><a href="{{ url('/huan-luyen-vien') }}">Huấn luyện viên</a></li>
                    <li><a href="{{ url('/lich-lop') }}">Lịch lớp</a></li>
                    <li><a href="{{ url('/goi-tap') }}">Gói tập</a></li>
                    <li><a href="{{ url('/tin-tuc') }}">Tin tức</a></li>
                    <li><a href="{{ url('/lien-he') }}">Liên hệ</a></li>
                </ul>
            </div>

            {{-- Col 3: Support --}}
            <div class="footer-col">
                <h4 class="footer-title">Hỗ trợ</h4>
                <ul class="footer-links">
                    <li><a href="#">Câu hỏi thường gặp</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                    <li><a href="#">Hướng dẫn đặt lịch</a></li>
                </ul>
            </div>

            {{-- Col 4: Contact --}}
            <div class="footer-col">
                <h4 class="footer-title">Liên hệ</h4>
                <ul class="footer-contact">
                    <li><i class="fas fa-map-marker-alt"></i><span>123 Đường Thể Thao, Quận 1, TP.HCM</span></li>
                    <li><i class="fas fa-phone"></i><span>0909 123 456</span></li>
                    <li><i class="fas fa-envelope"></i><span>info@extrafit.vn</span></li>
                    <li><i class="fas fa-clock"></i><span>5:00 – 22:00 (Hàng ngày)</span></li>
                </ul>
            </div>
        </div>

        <div class="footer-divider"></div>

        <div class="footer-bottom">
            <p>© 2025 <strong>EXTRA FIT+</strong>. All rights reserved.</p>
        </div>
    </div>
</footer>

{{-- Toast Container --}}
<div class="toast-container" id="toastContainer"></div>

<!-- Scripts -->
<script src="{{ asset('js/main.js') }}"></script>
@yield('scripts')
</body>
</html>