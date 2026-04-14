<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Đăng nhập | GYMFIT+</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;700;800;900&amp;family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
          tailwind.config = {
            darkMode: "class",
            theme: {
              extend: {
                "colors": {
                        "tertiary": "#1e333f",
                        "tertiary-container": "#d0e6f5",
                        "surface-variant": "#e2e2e2",
                        "surface-tint": "#007AFF",
                        "primary-container": "#E5F1FF",
                        "inverse-primary": "#E5F1FF",
                        "secondary-fixed": "#B2D7FF",
                        "on-primary": "#ffffff",
                        "on-secondary-fixed": "#001B3D",
                        "on-secondary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-high": "#f0f0f0",
                        "inverse-on-surface": "#f4f4f4",
                        "on-primary-fixed": "#001B3D",
                        "secondary": "#0056B3",
                        "on-tertiary-fixed-variant": "#354956",
                        "surface-container-low": "#f7f7f7",
                        "surface-container": "#f1f1f1",
                        "outline-variant": "#c3caac",
                        "on-primary-fixed-variant": "#003A7A",
                        "surface": "#fafafa",
                        "surface-container-highest": "#e2e2e2",
                        "secondary-container": "#D1E9FF",
                        "on-background": "#1b1b1b",
                        "primary-fixed-dim": "#4D9FFF",
                        "on-surface": "#1b1b1b",
                        "tertiary-fixed-dim": "#b4c9d9",
                        "error-container": "#ffdad6",
                        "error": "#ba1a1a",
                        "on-secondary-container": "#001B3D",
                        "on-tertiary-fixed": "#071e29",
                        "outline": "#767d60",
                        "surface-dim": "#dedede",
                        "secondary-fixed-dim": "#80BFFF",
                        "primary": "#007AFF",
                        "on-surface-variant": "#434933",
                        "tertiary-fixed": "#d0e6f5",
                        "on-secondary-fixed-variant": "#003A7A",
                        "background": "#fafafa",
                        "on-primary-container": "#001B3D",
                        "on-error-container": "#410002",
                        "surface-bright": "#ffffff",
                        "inverse-surface": "#303030",
                        "primary-fixed": "#E5F1FF",
                        "on-tertiary-container": "#001e2e",
                        "on-error": "#ffffff"
                },
                "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                },
                "fontFamily": {
                        "headline": ["Lexend"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                }
              },
            },
          }
        </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24
        }
        .kinetic-gradient {
            background: linear-gradient(45deg, #007AFF 0%, #4D9FFF 100%)
        }
        .mesh-overlay {
            background-image: radial-gradient(at 0% 0%, hsla(210, 100%, 20%, 0.4) 0, transparent 50%), radial-gradient(at 100% 100%, hsla(210, 100%, 40%, 0.2) 0, transparent 50%)
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6)
        }
        body {
            min-height: 100dvh
        }
        .bg-gym {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(https://lh3.googleusercontent.com/aida-public/AB6AXuBkBbzdNT14wafTViDAovVIbLB10OVvPB06MGPmPXRtCsC_1gx6xegRHIkdmHk16s4OPWasTHRqdsGv8VXS261PZyjDJL5fnX9ksthsLk8zNHZRgi4G84YNVUz1YIOF1AWK7plqtMkFO0XpK47zCcQgzmKF34TMqXZz1X7AOlFuP_HCmpGXgp0urhed-ky0NDp-5D7vNKk_FFu8-lKxYE6X_FB4kCSUA0AhzfdKyEEKeBj5kFsfwDVIXuYtNDhdw7aGX-JqurEd18Q);
            background-size: cover;
            background-position: center
        }
    </style>
</head>
<body class="bg-gym font-body text-on-surface flex items-center justify-center overflow-x-hidden p-4">
    <!-- Main Content Container -->
    <main class="relative z-10 w-full max-w-md flex flex-col gap-8">
        <!-- Header/Logo Section -->
        <header class="flex flex-col items-center text-center">
            <h1 class="font-headline font-black italic text-6xl tracking-widest text-white drop-shadow-[0_4px_12px_rgba(0,0,0,0.5)] mb-2">
                GYMFIT+
            </h1>
            <p class="font-headline font-bold text-white/90 text-lg uppercase tracking-[0.2em] drop-shadow-md">
                VƯỢT QUA MỌI GIỚI HẠN
            </p>
        </header>

        <!-- Session Status -->
        @if (session('status'))
            <div class="glass-card p-4 rounded-xl text-center text-primary font-bold">
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form Section -->
        <section class="flex flex-col gap-6">
            <!-- Glassmorphism Form Card -->
            <div class="glass-card p-1 rounded-2xl shadow-2xl">
                <form action="{{ route('login') }}" method="POST" class="bg-white/50 p-8 rounded-xl flex flex-col gap-6">
                    @csrf
                    <!-- Email Input Group -->
                    <div class="flex flex-col gap-2">
                        <label class="font-label text-[10px] font-bold tracking-[0.2em] text-on-surface-variant uppercase pl-1 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[14px]">mail</span> Địa chỉ Email
                        </label>
                        <div class="relative group">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary scale-y-0 group-focus-within:scale-y-100 transition-transform duration-300 rounded-full"></div>
                            <input class="w-full bg-white/80 border-none focus:ring-2 focus:ring-primary/20 text-on-surface py-4 px-4 placeholder:text-zinc-400 font-medium rounded-lg transition-all" 
                                   placeholder="athlete@gymfit.com" type="email" name="email" value="{{ old('email') }}" required autofocus/>
                        </div>
                        @error('email')
                            <p class="text-error text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Password Input Group -->
                    <div class="flex flex-col gap-2">
                        <label class="font-label text-[10px] font-bold tracking-[0.2em] text-on-surface-variant uppercase pl-1 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[14px]">lock</span> Mật khẩu
                        </label>
                        <div class="relative group">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary scale-y-0 group-focus-within:scale-y-100 transition-transform duration-300 rounded-full"></div>
                            <input class="w-full bg-white/80 border-none focus:ring-2 focus:ring-primary/20 text-on-surface py-4 px-4 placeholder:text-zinc-400 font-medium rounded-lg transition-all" 
                                   placeholder="••••••••" type="password" name="password" required/>
                        </div>
                        @error('password')
                            <p class="text-error text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center gap-2 pl-1">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary/20">
                        <label for="remember_me" class="font-label text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Ghi nhớ đăng nhập</label>
                    </div>

                    <!-- Primary Action -->
                    <button type="submit" class="kinetic-gradient w-full py-4 rounded-lg font-headline font-black text-on-primary text-center uppercase tracking-widest hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-primary/25 mt-2">
                        ĐĂNG NHẬP NGAY
                    </button>
                </form>
            </div>
            <!-- Divider -->
            <div class="flex items-center gap-4 px-4">
                <div class="h-[1px] flex-1 bg-white/30"></div>
                <span class="font-label text-[10px] font-bold text-white/80 uppercase tracking-[0.3em]">Hoặc kết nối với</span>
                <div class="h-[1px] flex-1 bg-white/30"></div>
            </div>
            <!-- Social Logins Grid -->
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('login.social', 'google') }}" aria-label="Đăng nhập với Google" class="flex items-center justify-center bg-white hover:bg-white/90 py-4 rounded-xl transition-all active:scale-95 border border-white/50 shadow-md group">
                    <svg class="w-6 h-6" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"></path>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                    </svg>
                </a>
                <a href="{{ route('login.social', 'facebook') }}" aria-label="Đăng nhập với Facebook" class="flex items-center justify-center bg-white hover:bg-white/90 py-4 rounded-xl transition-all active:scale-95 border border-white/50 shadow-md group">
                    <svg class="w-6 h-6" fill="#1877F2" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                    </svg>
                </a>
            </div>
        </section>
        <!-- Footer / Redirect -->
        <footer class="mt-4 text-center flex flex-col gap-3">
            <p class="font-body text-white/80 text-sm drop-shadow-sm">
                Chưa có tài khoản? 
                <a class="text-white font-bold underline decoration-white/50 underline-offset-4 hover:decoration-white transition-colors" href="{{ route('register') }}">Đăng ký ngay</a>
            </p>
            @if (Route::has('password.request'))
                <a class="font-label text-[10px] font-bold text-white/60 hover:text-white transition-colors uppercase tracking-[0.2em] drop-shadow-sm" href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            @endif
        </footer>
    </main>
    <!-- Subtle floating fitness icons in corners -->
    <div class="fixed top-8 right-8 text-white/10 pointer-events-none select-none">
        <span class="material-symbols-outlined text-8xl">fitness_center</span>
    </div>
    <div class="fixed bottom-8 left-8 text-white/10 pointer-events-none select-none">
        <span class="material-symbols-outlined text-8xl">exercise</span>
    </div>
</body>
</html>
