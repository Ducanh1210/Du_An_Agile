<!DOCTYPE html>
<html class="light" lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Đăng ký | GYM FIT+</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&amp;family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet"/>
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
        </style>
    <style>
        body {
          min-height: max(884px, 100dvh);
        }
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen flex flex-col">
<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 bg-background/80 backdrop-blur-xl">
    <div class="flex items-center justify-between px-6 h-16 w-full max-w-screen-xl mx-auto">
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="material-symbols-outlined text-primary cursor-pointer hover:scale-110 transition-transform">arrow_back</a>
            <span class="text-2xl font-black tracking-tighter text-primary font-headline">GYM FIT+</span>
        </div>
    </div>
</header>

<main class="flex-grow pt-16 flex flex-col md:flex-row items-stretch">
    <!-- Hero Section -->
    <div class="relative w-full md:w-1/2 min-h-[300px] md:min-h-screen overflow-hidden">
        <img alt="High Intensity Training" class="absolute inset-0 w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBfsvSyVxqzF6Okz94VgmFIgmH3YcUoCPlTLWLjlpup2KXpFEwJpwO_418jY9adhppoWH4qmIeQHtW-AoTgEwJQS-_X_KQ0Ola1gWBxdLv6RRExwtaaMoqyiKZCzDPbF08qKmEQjIrJ_DoAO6qClx28iAVh7hReqBZsY-_LNDK7RPI-q3Jh9blC59qTKu-GkaGJlHzmtC9C3DeRdOfLGzp_ZItifxOifhm7s4qw-cl-pl7uPoUSgChiJ_t9NJPBagQFPPfINghcuM8x"/>
        <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent md:bg-gradient-to-r md:from-transparent md:to-background"></div>
        <div class="absolute bottom-12 left-8 md:left-12 max-w-md">
            <p class="text-inverse-primary font-headline font-bold text-sm tracking-[0.2em] uppercase mb-2">Bắt đầu hành trình</p>
            <h1 class="text-white md:text-on-surface font-headline font-extrabold text-5xl md:text-6xl leading-tight tracking-tighter">
                KHÔNG GÌ LÀ <br/> <span class="text-inverse-primary">KHÔNG THỂ</span>
            </h1>
        </div>
    </div>
    
    <!-- Registration Form Section -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-6 md:p-12 lg:p-24 bg-background">
        <div class="w-full max-w-md">
            <div class="mb-10">
                <h2 class="text-3xl font-headline font-bold text-on-surface mb-2">Đăng ký tài khoản</h2>
                <p class="text-on-surface-variant font-medium">Tham gia cộng đồng GYM FIT+ ngay hôm nay.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-6" x-data="{ showPass: false, showConfirm: false }">
                @csrf
                <!-- Name Input -->
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-on-surface-variant ml-1" for="name">Họ tên</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">person</span>
                        <input id="name" name="name" value="{{ old('name') }}" required autofocus class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary/40 text-on-surface placeholder:text-outline-variant transition-all" placeholder="Nguyễn Văn A" type="text"/>
                    </div>
                    @error('name')
                        <p class="text-error text-[11px] font-bold ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email Input -->
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-on-surface-variant ml-1" for="email">Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">mail</span>
                        <input id="email" name="email" value="{{ old('email') }}" required class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary/40 text-on-surface placeholder:text-outline-variant transition-all" placeholder="example@gymfit.com" type="email"/>
                    </div>
                    @error('email')
                        <p class="text-error text-[11px] font-bold ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Password Input -->
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-on-surface-variant ml-1" for="password">Mật khẩu</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">lock</span>
                        <input id="password" name="password" required x-bind:type="showPass ? 'text' : 'password'" class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-12 focus:ring-2 focus:ring-primary/40 text-on-surface placeholder:text-outline-variant transition-all" placeholder="••••••••"/>
                        <span @click="showPass = !showPass" class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline text-lg cursor-pointer hover:text-primary transition-colors" x-text="showPass ? 'visibility_off' : 'visibility'">visibility</span>
                    </div>
                    @error('password')
                        <p class="text-error text-[11px] font-bold ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirm Password Input -->
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold uppercase tracking-widest text-on-surface-variant ml-1" for="password_confirmation">Xác nhận mật khẩu</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">shield</span>
                        <input id="password_confirmation" name="password_confirmation" required x-bind:type="showConfirm ? 'text' : 'password'" class="w-full bg-surface-container-low border-none rounded-xl py-4 pl-12 pr-12 focus:ring-2 focus:ring-primary/40 text-on-surface placeholder:text-outline-variant transition-all" placeholder="••••••••"/>
                        <span @click="showConfirm = !showConfirm" class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline text-lg cursor-pointer hover:text-primary transition-colors" x-text="showConfirm ? 'visibility_off' : 'visibility'">visibility</span>
                    </div>
                    @error('password_confirmation')
                        <p class="text-error text-[11px] font-bold ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <div class="pt-4">
                    <button class="w-full bg-gradient-to-r from-primary to-primary-container text-on-primary font-bold py-5 rounded-full shadow-lg shadow-primary/20 active:scale-95 transition-transform uppercase tracking-widest" type="submit">
                        Tạo tài khoản
                    </button>
                </div>
                
                <!-- Footer Links -->
                <div class="text-center space-y-4 pt-6">
                    <p class="text-on-surface-variant font-medium">
                        Đã có tài khoản? 
                        <a class="text-primary font-bold hover:underline ml-1" href="{{ route('login') }}">Đăng nhập</a>
                        <span class="mx-2 text-outline-variant">|</span>
                        <a class="text-primary font-bold hover:underline" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Bottom Margin -->
<footer class="pb-8 md:pb-0 bg-background text-center py-6 px-4">
    <p class="text-[10px] font-bold text-outline-variant/60 uppercase tracking-[0.2em]">© {{ date('Y') }} GYM FIT+ GLOBAL ECOSYSTEM. ALL RIGHTS RESERVED.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
