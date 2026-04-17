<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Đặt lại mật khẩu | GYM FIT+</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;900&amp;family=Manrope:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#9c3f00",
                        "on-primary": "#fff0ea",
                        "background": "#fff4ef",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#4a2506",
                        "on-surface-variant": "#7f512e",
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
                        "body": ["Manrope"]
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
<div class="fixed inset-0 z-0">
    <img alt="Professional gym setting" class="w-full h-full object-cover grayscale-[10%] contrast-[1.05]" src="https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=1600&q=80"/>
    <div class="absolute inset-0 bg-background/80 backdrop-blur-sm"></div>
</div>

<header class="fixed top-0 w-full z-50 bg-background/90 backdrop-blur-md">
    <nav class="flex items-center justify-center px-6 h-16 w-full max-w-screen-xl mx-auto">
        <h1 class="text-2xl font-black tracking-tighter text-primary font-headline">GYM FIT+</h1>
    </nav>
</header>

<main class="relative z-10 min-h-screen pt-24 pb-12 flex flex-col items-center justify-center">
    <div class="w-full max-w-md px-6">
        <div class="bg-surface-container-lowest rounded-[2.5rem] p-8 md:p-10 shadow-[0_32px_64px_-12px_rgba(74,37,6,0.12)] border border-white/40">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-full mb-4">
                    <span class="material-symbols-outlined text-primary text-3xl">lock_open</span>
                </div>
                <h3 class="font-headline text-2xl font-bold text-on-surface mb-2 tracking-tight">Mật khẩu mới</h3>
                <p class="text-on-surface-variant text-sm leading-relaxed">
                    OTP chính xác! Thiết lập mật khẩu mới cho:<br>
                    <strong class="text-primary">{{ $email }}</strong>
                </p>
            </div>

            <form method="POST" action="{{ route('password.update.final') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="otp" value="{{ $otp }}">

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant/70 ml-1" for="password">Mật khẩu mới</label>
                    <div class="relative group" x-data="{ show: false }">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-on-surface-variant group-focus-within:text-primary">
                            <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                        </div>
                        <input x-bind:type="show ? 'text' : 'password'" class="w-full pl-12 pr-12 py-4 bg-slate-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl focus:ring-0 text-on-surface font-semibold placeholder:text-on-surface-variant/30 transition-all font-medium" 
                               id="password" name="password" required autofocus placeholder="••••••••" type="password"/>
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary">
                            <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-error text-xs ml-1 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant/70 ml-1" for="password_confirmation">Xác nhận mật khẩu</label>
                    <div class="relative group" x-data="{ show: false }">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-on-surface-variant group-focus-within:text-primary">
                            <span class="material-symbols-outlined text-[20px]">lock_check</span>
                        </div>
                        <input x-bind:type="show ? 'text' : 'password'" class="w-full pl-12 pr-12 py-4 bg-slate-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl focus:ring-0 text-on-surface font-semibold placeholder:text-on-surface-variant/30 transition-all font-medium" 
                               id="password_confirmation" name="password_confirmation" required placeholder="••••••••" type="password"/>
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary">
                            <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                        </button>
                    </div>
                </div>

                <button class="w-full kinetic-gradient text-on-primary font-bold py-4 rounded-2xl shadow-xl shadow-electric-orange/20 hover:shadow-electric-orange/30 active:scale-[0.98] transition-all flex items-center justify-center gap-2 group" type="submit">
                    Cập nhật mật khẩu
                    <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">check_circle</span>
                </button>
            </form>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
