<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Quên mật khẩu | GYM FIT+</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;900&amp;family=Manrope:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-fixed-variant": "#803f00",
                        "tertiary-dim": "#6b4900",
                        "on-tertiary": "#fff1df",
                        "error": "#b02500",
                        "tertiary-fixed": "#fbb423",
                        "on-secondary": "#fff0e8",
                        "error-container": "#f95630",
                        "background": "#fff4ef",
                        "surface-container-high": "#ffdcc6",
                        "on-tertiary-container": "#523700",
                        "surface-dim": "#ffc9a6",
                        "on-primary": "#fff0ea",
                        "surface-tint": "#9c3f00",
                        "primary-fixed": "#ff7a2f",
                        "error-dim": "#b92902",
                        "secondary-dim": "#7e3e00",
                        "primary-container": "#ff7a2f",
                        "secondary-container": "#ffc69f",
                        "surface": "#fff4ef",
                        "tertiary-fixed-dim": "#eba60f",
                        "on-secondary-container": "#723700",
                        "surface-container-lowest": "#ffffff",
                        "surface-variant": "#ffd4b9",
                        "inverse-primary": "#fe6b00",
                        "on-surface-variant": "#7f512e",
                        "surface-container-low": "#ffede4",
                        "tertiary-container": "#fbb423",
                        "on-error": "#ffefec",
                        "primary": "#9c3f00",
                        "on-surface": "#4a2506",
                        "tertiary": "#7a5400",
                        "on-primary-fixed": "#000000",
                        "secondary-fixed": "#ffc69f",
                        "on-tertiary-fixed-variant": "#5e4000",
                        "on-error-container": "#520c00",
                        "secondary-fixed-dim": "#ffb37d",
                        "surface-container": "#ffe3d2",
                        "inverse-surface": "#1c0900",
                        "outline": "#9e6b47",
                        "inverse-on-surface": "#c99169",
                        "surface-bright": "#fff4ef",
                        "surface-container-highest": "#ffd4b9",
                        "outline-variant": "#dba078",
                        "on-secondary-fixed": "#552800",
                        "primary-dim": "#893600",
                        "on-tertiary-fixed": "#372400",
                        "on-primary-fixed-variant": "#4f1c00",
                        "secondary": "#904800",
                        "primary-fixed-dim": "#f66700",
                        "on-primary-container": "#401500",
                        "on-background": "#4a2506",
                        "electric-orange": "#FF6B00"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline": ["Space Grotesk"],
                        "body": ["Manrope"],
                        "label": ["Manrope"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .kinetic-gradient {
            background: linear-gradient(135deg, #FF6B00 0%, #FF8A00 100%);
        }
    </style>
</head>
<body class="bg-background font-body text-on-surface selection:bg-secondary-container min-h-screen">
<!-- Background Image Container -->
<div class="fixed inset-0 z-0">
    <img alt="Professional gym setting" class="w-full h-full object-cover grayscale-[10%] contrast-[1.05]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBeFx3nQ_dwd0mDPCgcH0cquya7SSxvZRT1hvc4Q3WL7r7ugHxcAI-LzkbeOIAZY3J_9pMY0lU85v6da3kGDNXZkncK36ciMR5zodl77CQA0YF_BkUeX3VPjJdqUdC5N3gbREOxBPqlZCvqFzKuqayDk9gPvIYwRR2HA9zgO5dQTAhRsyys3VgNbsKD57RHWl7oZhakANdjVCs2ekEqODcMI5wDBXSWaaJmJ3MpPTPP1CXxVYEbAzbK-e-kxurtPLY_M31RPiC-iCWZ"/>
    <div class="absolute inset-0 bg-background/80 backdrop-blur-sm"></div>
</div>

<header class="fixed top-0 w-full z-50 bg-background/90 backdrop-blur-md">
    <nav class="flex items-center justify-center px-6 h-16 w-full max-w-screen-xl mx-auto">
        <h1 class="text-2xl font-black tracking-tighter text-primary dark:text-[#fe6b00] font-['Space_Grotesk']">GYM FIT+</h1>
    </nav>
</header>

<main class="relative z-10 min-h-screen pt-24 pb-12 flex flex-col items-center justify-center">
    <div class="w-full max-w-md px-6">
        <!-- Form Section -->
        <div class="bg-surface-container-lowest rounded-[2.5rem] p-8 md:p-10 shadow-[0_32px_64px_-12px_rgba(74,37,6,0.12)] border border-white/40">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-full mb-4">
                    <span class="material-symbols-outlined text-primary text-3xl" data-icon="lock_reset">lock_reset</span>
                </div>
                <h3 class="font-headline text-2xl font-bold text-on-surface mb-2 tracking-tight">Quên mật khẩu?</h3>
                <p class="text-on-surface-variant text-sm leading-relaxed px-4">Đừng lo lắng, hãy nhập email của bạn dưới đây để nhận hướng dẫn khôi phục.</p>
            </div>

            <!-- Session Status Message -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 text-sm font-medium border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('otp.send') }}" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="font-label text-xs font-bold uppercase tracking-wider text-on-surface-variant/70 ml-1" for="email">Địa chỉ Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-on-surface-variant group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]" data-icon="mail">mail</span>
                        </div>
                        <input class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl focus:ring-0 text-on-surface placeholder:text-on-surface-variant/40 transition-all font-medium" 
                               id="email" name="email" value="{{ old('email') }}" autofocus placeholder="username@email.com" type="email"/>
                    </div>
                    @error('email')
                        <p class="text-error text-xs ml-1 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button class="w-full kinetic-gradient text-on-primary font-bold py-4 rounded-2xl shadow-xl shadow-electric-orange/20 hover:shadow-electric-orange/30 active:scale-[0.98] transition-all flex items-center justify-center gap-2 group" type="submit">
                    Gửi mã xác thực OTP
                    <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform" data-icon="arrow_forward">arrow_forward</span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-outline-variant/10">
                <div class="flex flex-col items-center gap-3 text-sm font-medium">
                    <a class="text-primary hover:text-primary-dim transition-colors flex items-center gap-1" href="{{ route('login') }}">
                        <span class="material-symbols-outlined text-sm" data-icon="login">login</span>
                        Quay lại Đăng nhập
                    </a>
                    <div class="flex items-center gap-2">
                        <span class="text-on-surface-variant/60 text-xs">Bạn chưa có tài khoản?</span>
                        <a class="text-on-surface hover:text-primary underline decoration-primary/30 underline-offset-4 transition-colors" href="{{ route('register') }}">Đăng ký ngay</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Info -->
        <div class="mt-12 flex flex-col items-center gap-4 text-center">
            <p class="text-[10px] font-bold tracking-[0.4em] text-on-surface-variant/40 uppercase">Secure Recovery System</p>
            <div class="flex gap-6 opacity-60">
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs" data-icon="verified_user">verified_user</span>
                    <span class="text-[10px] font-bold">Bảo mật</span>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs" data-icon="bolt">bolt</span>
                    <span class="text-[10px] font-bold">Nhanh chóng</span>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
