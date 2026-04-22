<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="EXTRA FIT+ GYM & FITNESS - Trung tâm thể hình hàng đầu. Huấn luyện viên chuyên nghiệp, lá»›p há»c đa dạng, cơ sá»Ÿ váº­t cháº¥t hiện đại.">
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
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
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
            <a href="{{ url('/lich-lop') }}" class="nav-link {{ request()->is('lich-lop*') ? 'active' : '' }}">Lịch lớp</a>
            <a href="{{ route('trainers') }}" class="nav-link {{ request()->is('huan-luyen-vien*') ? 'active' : '' }}">Đặt lịch PT</a>
            <a href="{{ route('client.memberships') }}" class="nav-link {{ request()->is('goi-tap*') ? 'active' : '' }}">Gói tập</a>
            <a href="{{ url('/tin-tuc') }}" class="nav-link {{ request()->is('tin-tuc*') ? 'active' : '' }}">Tin tức</a>
            <a href="{{ url('/lien-he') }}" class="nav-link {{ request()->is('lien-he*') ? 'active' : '' }}">Liên hệ</a>
        </nav>
        {{-- Header Actions --}}
        <div class="header-actions">
            {{-- Notification Bell --}}
            @auth
            <div class="notification-dropdown" id="notifDropdown">
                <button class="header-icon-btn" id="notificationBtn" title="Thông báo" aria-label="Thông báo">
                    <i class="fas fa-bell"></i>
                    @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                    <span class="badge-count {{ $unreadCount > 0 ? '' : 'd-none' }}" id="notifCount">{{ $unreadCount }}</span>
                </button>
                <div class="notif-menu" id="notifMenu">
                    <div class="notif-header">
                        <h5 class="mb-0">Thông báo</h5>
                        <button id="markAllRead" class="btn-link">Đọc tất cả</button>
                    </div>
                    <div class="notif-body" id="notifList">
                        {{-- Dữ liệu được load bằng AJAX --}}
                        <div class="notif-empty p-3 text-center text-muted">Đang tải...</div>
                    </div>
                    <div class="notif-footer">
                        <a href="{{ route('notifications.index') }}">Xem tất cả thông báo</a>
                    </div>
                </div>
            </div>
            @else
            <button class="header-icon-btn" title="Thông báo" onclick="window.location='{{ route('login') }}'">
                <i class="fas fa-bell"></i>
            </button>
            @endauth
            {{-- Dark Mode Toggle --}}
            <button class="header-icon-btn dark-toggle" id="darkModeToggle" title="Đổi giao diện" aria-label="Chế độ tối">
                <i class="fas fa-moon" id="darkIcon"></i>
            </button>
            {{-- Login/Register (hiá»‡n khi chưa đăng nhập) --}}
            @guest
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Đăng nhập</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Đăng ký</a>
            </div>
            @endguest
            {{-- User Dropdown (hiá»‡n khi đÃ£ đăng nhập) --}}
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
        <a href="{{ url('/lich-lop') }}" class="drawer-link"><i class="fas fa-calendar-alt"></i> Lịch lớp</a>
        <a href="{{ route('trainers') }}" class="drawer-link {{ request()->is('huan-luyen-vien*') ? 'active' : '' }}"><i class="fas fa-user-check"></i> Đặt lịch PT</a>
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
    <script>
    /* ============================================================
       NOTIFICATION DROPDOWN
       ============================================================ */
    const notifDropdown = document.getElementById('notifDropdown');
    const notifBtn      = document.getElementById('notificationBtn');
    const notifMenu     = document.getElementById('notifMenu');
    const notifList     = document.getElementById('notifList');
    const notifCount    = document.getElementById('notifCount');
    const markAllRead   = document.getElementById('markAllRead');

    if (notifDropdown && notifBtn) {
        notifBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = notifMenu.classList.toggle('show');
            if (isOpen) {
                loadRecentNotifications();
                // Close user dropdown if open
                document.getElementById('userDropdown')?.classList.remove('open');
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!notifDropdown.contains(e.target)) {
                notifMenu.classList.remove('show');
            }
        });

        markAllRead?.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            fetch('/api/notifications/read-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    notifCount.classList.add('d-none');
                    notifCount.textContent = '0';
                    loadRecentNotifications(); // Reload list
                }
            });
        });
    }

    function loadRecentNotifications() {
        if (!notifList) return;
        
        fetch('/api/notifications/recent')
            .then(res => res.json())
            .then(data => {
                renderNotifications(data.notifications);
                if (data.unread_count > 0) {
                    notifCount.classList.remove('d-none');
                    notifCount.textContent = data.unread_count;
                } else {
                    notifCount.classList.add('d-none');
                }
            });
    }

    function renderNotifications(notifications) {
        if (!notifications || notifications.length === 0) {
            notifList.innerHTML = '<div class="notif-empty p-4 text-center text-muted">Bạn chưa có thông báo nào</div>';
            return;
        }

        notifList.innerHTML = notifications.map(n => {
            const icon = getNotifIcon(n.type);
            return `
                <a href="${n.link}" class="notif-item ${n.read_at ? '' : 'unread'}" data-id="${n.id}">
                    <div class="notif-icon" style="background: ${icon.bg}; color: ${icon.color}">
                        <i class="fas ${icon.fa}"></i>
                    </div>
                    <div class="notif-content">
                        <span class="notif-title">${n.title}</span>
                        <span class="notif-msg">${n.message}</span>
                        <span class="notif-time">${n.created_at}</span>
                    </div>
                </a>
            `;
        }).join('');

        // Add click listeners to mark as read
        notifList.querySelectorAll('.notif-item.unread').forEach(item => {
            item.addEventListener('click', function(e) {
                const id = this.dataset.id;
                fetch(`/api/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json'
                    }
                });
            });
        });
    }

    function getNotifIcon(type) {
        switch(type) {
            case 'membership_expiring': return { fa: 'fa-calendar-exclamation', bg: '#FFF0EA', color: '#FF6B35' };
            case 'session_reminder':   return { fa: 'fa-bell', bg: '#EBFBEE', color: '#40C057' };
            case 'reschedule_request': return { fa: 'fa-clock', bg: '#FFF9DB', color: '#FAB005' };
            case 'session_report':     return { fa: 'fa-file-invoice', bg: '#E7F5FF', color: '#228BE6' };
            default:                   return { fa: 'fa-info-circle', bg: '#F8F9FA', color: '#adb5bd' };
        }
    }
    </script>
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
                <h4 class="footer-title">Điá»u hướng</h4>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li><a href="{{ url('/lich-lop') }}">Lịch lớp</a></li>
                    <li><a href="{{ route('trainers') }}">Đặt lịch PT</a></li>
                    <li><a href="{{ url('/goi-tap') }}">Gói tập</a></li>
                    <li><a href="{{ url('/tin-tuc') }}">Tin tức</a></li>
                    <li><a href="{{ url('/lien-he') }}">Liên hệ</a></li>
                </ul>
            </div>
            {{-- Col 3: Support --}}
            <div class="footer-col">
                <h4 class="footer-title">Hỗ trợ</h4>
                <ul class="footer-links">
                    <li><a href="#">Câu há»i thưá»ng gáº·p</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Điá»u khoản sử dụng</a></li>
                    <li><a href="#">Hướng dẫn đặt lịch</a></li>
                </ul>
            </div>
            {{-- Col 4: Contact --}}
            <div class="footer-col">
                <h4 class="footer-title">Liên hệ</h4>
                <ul class="footer-contact">
                    <li><i class="fas fa-map-marker-alt"></i><span>123 Đưá»ng Thá»ƒ Thao, Quận 1, TP.HCM</span></li>
                    <li><i class="fas fa-phone"></i><span>0909 123 456</span></li>
                    <li><i class="fas fa-envelope"></i><span>info@extrafit.vn</span></li>
                    <li><i class="fas fa-clock"></i><span>5:00 â€“ 22:00 (Hàng ngày)</span></li>
                </ul>
            </div>
        </div>
        <div class="footer-divider"></div>
        <div class="footer-bottom">
            <p>Â© 2025 <strong>EXTRA FIT+</strong>. All rights reserved.</p>
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
