<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Đăng nhập | GYM FIT+</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;800;900&amp;family=Manrope:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
                        "on-background": "#4a2506"
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
        body { font-family: 'Manrope', sans-serif; }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            min-height: 100dvh;
        }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen flex flex-col relative overflow-x-hidden">
<!-- Full Background Section -->
<div class="fixed inset-0 z-0">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBeZgJmEcHm3JCQ9WHcfyeLZ3ivceFiE8J4XbJMGvY-lZUbW8wsssY5izr0C1O-xrgaDtAFCESn_W4Gu6lQIMz4c-PfRWwOsata7_4hKcbcYLZ-a4YX4GySKVtBNHbXfFNeBhzNhNQPCWienNsp9V5d0XzLoNjQmNu_tpBRtPksiaiO3pHBRGYaUNAJOzCtKuL9R8Xl3y76vvtmP7LFxa-DFR-hoc0WS62MnWcLhXXcNvM0qTaA3H5yexUvCY9_OinAoxV1mft5SZ_C')"></div>
    <!-- Gradient Overlay for readability -->
    <div class="absolute inset-0 bg-gradient-to-t from-background via-background/60 to-primary/20"></div>
</div>

<!-- Main Content -->
<main class="flex-grow flex flex-col items-center justify-center px-6 py-12 relative z-10">
    <!-- Brand Logo -->
    <div class="mb-10 text-center">
        <h1 class="font-headline font-black italic text-5xl md:text-6xl tracking-tighter text-on-primary-container drop-shadow-2xl">
            GYM FIT+
        </h1>
        <p class="font-headline font-bold text-primary tracking-[0.3em] text-xs mt-3 uppercase opacity-90">Kinetic Performance</p>
    </div>

    <!-- Login Form Container -->
    <div class="w-full max-w-md bg-surface-container-lowest/95 backdrop-blur-md rounded-[2.5rem] p-8 md:p-12 shadow-[0_32px_64px_rgba(74,37,6,0.18)]">
        <div class="mb-10 text-center">
            <h2 class="font-headline text-3xl font-bold text-on-surface leading-tight">Chào mừng trở lại</h2>
            <p class="text-on-surface-variant mt-3 text-sm">Vui lòng đăng nhập để tiếp tục hành trình.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('login') }}" class="space-y-6" method="POST">
            @csrf
            
            <!-- Email Input -->
            <div class="space-y-2">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1" for="email">Email</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">mail</span>
                    <input class="w-full bg-surface-container-low/50 border-2 border-transparent focus:border-primary/20 rounded-2xl py-4 pl-12 pr-4 focus:ring-0 transition-all placeholder:text-on-surface-variant/40 text-on-surface font-semibold" 
                           id="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" type="email" required autofocus/>
                </div>
                @error('email')
                    <p class="text-error text-xs ml-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="space-y-2">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1" for="password">Mật khẩu</label>
                <div class="relative group" x-data="{ show: false }">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">lock</span>
                    <input x-bind:type="show ? 'text' : 'password'" class="w-full bg-surface-container-low/50 border-2 border-transparent focus:border-primary/20 rounded-2xl py-4 pl-12 pr-12 focus:ring-0 transition-all placeholder:text-on-surface-variant/40 text-on-surface font-semibold" 
                           id="password" name="password" placeholder="••••••••" required/>
                    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors" type="button" @click="show = !show">
                        <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p class="text-error text-xs ml-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mt-4" style="display: none;">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2">
                <label for="remember_me" class="ml-2 text-sm text-on-surface-variant">Ghi nhớ đăng nhập</label>
            </div>

            <!-- Action Button -->
            <div class="pt-4">
                <button class="w-full bg-gradient-to-r from-primary to-primary-fixed text-on-primary font-headline font-extrabold py-5 rounded-2xl shadow-xl shadow-primary/30 active:scale-[0.97] transition-all hover:brightness-110 uppercase tracking-widest text-sm" type="submit">
                    Đăng nhập
                </button>
            </div>
        </form>

        <!-- Links Section -->
        <div class="mt-10 flex flex-row items-center justify-between text-[13px] font-bold">
            <a class="text-inverse-primary hover:text-primary transition-colors" href="{{ route('register') }}">Đăng ký ngay</a>
            <span class="w-px h-4 bg-surface-variant"></span>
            @if (Route::has('password.request'))
                <a class="text-on-surface-variant hover:text-primary transition-colors italic font-medium" href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            @endif
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="py-8 px-6 text-center relative z-10">
    <p class="text-[10px] text-on-surface-variant/60 uppercase tracking-[0.25em] font-bold">
        © {{ date('Y') }} GYM FIT+ PERFORMANCE CENTER
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
