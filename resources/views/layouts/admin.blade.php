<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Gym Fit') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#ea580c', // Orange 600
                        secondary: '#1e293b', // Slate 800
                    }
                }
            }
        }
    </script>
    
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Outfit', sans-serif; }
        .sidebar-link.active {
            background-color: #ea580c;
            color: white;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        .sidebar-link:hover:not(.active) {
            background-color: #334155;
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-900 overflow-hidden">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
        
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Branding -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-orange-600/20">
                        <i class="fa-solid fa-dumbbell text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-white uppercase tracking-tighter ">GYM <span class="text-orange-500">FIT+</span></span>
                </div>
                <button class="lg:hidden text-slate-400" @click="sidebarOpen = false">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Menu -->
            <nav class="mt-6 px-4 space-y-1.5 overflow-y-auto max-h-[calc(100vh-160px)]">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-300 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line w-5"></i>
                    <span class="font-medium text-[15px]">Dashboard</span>
                </a>

                <div class="pt-5 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest leading-loose whitespace-nowrap">Hệ thống Dịch vụ</div>
                
                <a href="{{ route('admin.memberships.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-300 {{ request()->routeIs('admin.memberships.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-id-card w-5"></i>
                    <span class="font-medium text-[15px]">Quản lý Gói tập</span>
                </a>

                <a href="{{ route('admin.equipments.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-300 {{ request()->routeIs('admin.equipments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-dumbbell w-5"></i>
                    <span class="font-medium text-[15px]">Quản lý Dụng cụ</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-300 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users w-5"></i>
                    <span class="font-medium text-[15px]">Quản lý Người dùng</span>
                </a>

                <a href="{{ route('admin.schedules.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-300 {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-day w-5"></i>
                    <span class="font-medium text-[15px]">Quản lý Lịch lớp</span>
                </a>

                <div x-data="{ open: {{ request()->routeIs('admin.news.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="sidebar-link flex items-center justify-between w-full px-4 py-3 rounded-xl transition-all duration-200 text-slate-300 {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-newspaper w-5"></i>
                            <span class="font-medium text-[15px]">Quản lý Tin tức</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-cloak class="mt-1 ml-4 pl-4 border-l border-slate-700 space-y-1">
                        <a href="{{ route('admin.news.index') }}" class="block py-2 text-sm {{ request()->routeIs('admin.news.index') ? 'text-orange-500 font-bold' : 'text-slate-400 hover:text-white' }}">Bài viết</a>
                        <a href="{{ route('admin.news.categories.index') }}" class="block py-2 text-sm {{ request()->routeIs('admin.news.categories.*') ? 'text-orange-500 font-bold' : 'text-slate-400 hover:text-white' }}">Danh mục</a>
                        <a href="{{ route('admin.news.tags.index') }}" class="block py-2 text-sm {{ request()->routeIs('admin.news.tags.*') ? 'text-orange-500 font-bold' : 'text-slate-400 hover:text-white' }}">Hashtags</a>
                        <a href="{{ route('admin.news.comments.index') }}" class="block py-2 text-sm {{ request()->routeIs('admin.news.comments.*') ? 'text-orange-500 font-bold' : 'text-slate-400 hover:text-white' }}">Bình luận</a>
                    </div>
                </div>

                <div class="pt-5 pb-2 px-4 text-xs font-semibold text-slate-500 uppercase tracking-widest leading-loose whitespace-nowrap">Tài chính & Thống kê</div>

                <a href="{{ route('admin.revenue.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-300 {{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie w-5"></i>
                    <span class="font-medium text-[15px]">Thống kê Doanh thu</span>
                </a>

                <a href="{{ route('admin.payments.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-300 {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice-dollar w-5"></i>
                    <span class="font-medium text-[15px]">Quản lý Thanh toán</span>
                </a>
            </nav>

            <!-- Bottom Profile -->
            <div class="absolute bottom-0 w-full p-4 border-t border-slate-800 bg-slate-900/50 backdrop-blur-sm">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2 w-full rounded-lg text-slate-400 hover:text-red-400 hover:bg-red-500/10 transition-colors uppercase tracking-widest leading-relaxed">
                        <i class="fa-solid fa-power-off w-5"></i>
                        <span class="text-sm font-semibold uppercase tracking-widest leading-relaxed">Đăng xuất Admin</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
            
            <!-- Navbar / Header -->
            <header class="h-16 bg-white/80 backdrop-blur-md border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-40">
                <div class="flex items-center gap-4">
                    <button class="lg:hidden text-slate-600 focus:outline-none" @click="sidebarOpen = !sidebarOpen">
                        <i class="fa-solid fa-bars-staggered text-xl"></i>
                    </button>
                    <!-- Breadcrumbs -->
                    <nav class="hidden md:flex items-center text-sm font-medium text-slate-500">
                        <span class="hover:text-primary transition-colors cursor-pointer uppercase tracking-widest">Hệ thống</span>
                        <i class="fa-solid fa-chevron-right text-[10px] mx-3 text-slate-300"></i>
                        <span class="text-slate-900 font-bold uppercase tracking-tighter">@yield('title', 'Quản trị phòng Gym')</span>
                    </nav>
                </div>

                <div class="flex items-center gap-5">
                    <div class="relative hidden sm:block">
                        <input type="text" placeholder="Tìm nhanh..." class="bg-gray-100 border-none rounded-full px-5 py-1.5 text-sm w-48 focus:ring-2 focus:ring-orange-500/30 transition-all">
                        <i class="fa-solid fa-magnifying-glass absolute right-4 top-2.5 text-slate-400 text-xs"></i>
                    </div>
                    
                    <button class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-gray-100 transition relative">
                        <i class="fa-regular fa-bell text-lg"></i>
                        <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>

                    <div class="h-8 w-[1px] bg-gray-200 mx-1"></div>

                    <div class="flex items-center gap-3 cursor-pointer group">
                        <div class="text-right hidden lg:block">
                            <div class="text-sm font-bold text-slate-900 group-hover:text-primary transition-colors">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Quản trị viên</div>
                        </div>
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=ea580c&color=fff&bold=true" 
                                 class="w-10 h-10 rounded-xl border-2 border-white shadow-sm ring-1 ring-gray-200 transition-transform group-hover:scale-105">
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50/50 p-6 lg:p-8 scroll-smooth pb-20">
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 flex items-center gap-3 shadow-md rounded-2xl animate-fade-in">
                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center flex-shrink-0 animate-pulse">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                @endif

                @yield('content')
            </main>

            <!-- Copyright Sticky -->
            <div class="absolute bottom-6 right-8 pointer-events-none opacity-40 hidden lg:block">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">GYM FIT+ &copy; {{ date('Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
