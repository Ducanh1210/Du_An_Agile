    /* --- Ultimate Premium Trainer UI --- */
    :root {
        --p-color: #FF6B35;
        --p-glow: rgba(255, 107, 53, 0.4);
        --v-color: #6366f1;
        --v-glow: rgba(99, 102, 241, 0.4);
    }

    .trainer-hero {
        position: relative;
        height: 500px;
        display: flex;
        align-items: center;
        background: #0f172a;
        overflow: hidden;
    }
    .trainer-hero::after {
        content: '';
        position: absolute;
        width: 150%; height: 150%;
        background: radial-gradient(circle at 70% 30%, rgba(255,107,53,0.15) 0%, transparent 50%);
        top: -25%; left: -25%;
    }
    .hero-title {
        font-size: clamp(4rem, 8vw, 7rem);
        font-weight: 900;
        line-height: 0.9;
        letter-spacing: -2px;
        background: linear-gradient(to bottom, #fff 30%, rgba(255,255,255,0.4));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Filter System */
    .premium-filter {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 8px;
        border-radius: 100px;
        display: inline-flex;
        gap: 4px;
    }
    .filter-btn {
        padding: 12px 28px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: #94a3b8;
    }
    .filter-btn.active {
        background: #fff;
        color: #0f172a;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    /* Trainer Card - The Masterpiece */
    .trainer-card {
        background: #1e293b;
        border-radius: 40px;
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
    }
    .trainer-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 60px -15px rgba(0,0,0,0.5);
        border-color: rgba(255, 107, 53, 0.3);
    }
    .card-img-wrap {
        height: 420px;
        position: relative;
        overflow: hidden;
    }
    .card-img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 1s cubic-bezier(0.19, 1, 0.22, 1);
    }
    .trainer-card:hover .card-img { transform: scale(1.1); }
    
    .overlay-glow {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, #1e293b 0%, transparent 40%);
    }

    .card-body {
        padding: 40px;
        position: relative;
    }
    .spec-tag {
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--p-color);
        margin-bottom: 12px;
        display: block;
    }
    .name-text {
        font-size: 32px;
        font-weight: 900;
        color: #fff;
        margin-bottom: 8px;
    }
    .bio-text {
        font-size: 14px;
        color: #94a3b8;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .btn-book {
        width: 100%;
        padding: 20px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .trainer-card:hover .btn-book {
        background: var(--p-color);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 10px 30px var(--p-glow);
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-up { animation: fadeInUp 0.8s cubic-bezier(0.19, 1, 0.22, 1) forwards; }
</style>
@endsection

@section('breadcrumb')
<div class="bg-slate-900 border-none py-3">
    <div class="container mx-auto px-6 flex items-center gap-3">
        <div class="breadcrumb-item"><a href="{{ url('/') }}" class="text-slate-500 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest leading-none">Trang chủ</a></div>
        <div class="text-slate-700 font-bold text-[8px]"><i class="fas fa-chevron-right"></i></div>
        <div class="breadcrumb-item text-white font-black text-xs uppercase tracking-[0.2em] leading-none">Huấn luyện viên</div>
    </div>
</div>
@endsection

@section('content')
<section class="trainer-hero">
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl">
            <span class="inline-block px-4 py-2 rounded-full bg-primary/10 text-primary font-black text-[10px] uppercase tracking-widest mb-6 animate-up opacity-0" style="animation-delay: 0.1s">Extra Fit Elite Coach</span>
            <h1 class="hero-title mb-8 animate-up opacity-0" style="animation-delay: 0.2s">MASTER THE<br>CRAFT.</h1>
            <p class="text-slate-400 text-lg md:text-xl font-medium max-w-2xl animate-up opacity-0" style="animation-delay: 0.3s">
                Làm việc trực tiếp cùng những chuyên gia hàng đầu. Thay đổi tư duy, nâng tầm thể chất và phá vỡ mọi giới hạn bản thân.
            </p>
        </div>
    </div>
</section>

<div class="bg-slate-900 min-h-screen">
    <!-- Filter Section (Sticky) -->
    <div class="sticky top-0 z-50 py-10 bg-slate-900/80 backdrop-blur-xl border-b border-white/5">
        <div class="container mx-auto px-6 text-center">
            <div class="premium-filter animate-up opacity-0" style="animation-delay: 0.4s">
                <button class="filter-btn active" data-filter="all">Tất cả coach</button>
                <button class="filter-btn" data-filter="gym">Gym / Fitness</button>
                <button class="filter-btn" data-filter="yoga">Yoga chuyên sâu</button>
                <button class="filter-btn" data-filter="both">Đa năng (Dual)</button>
            </div>
        </div>
    </div>

    <!-- Trainers Grid -->
    <div class="container mx-auto px-6 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12" id="trainersGrid">
            @forelse($trainers as $trainer)
            <div class="trainer-card-wrapper animate-up opacity-0" data-specialization="{{ $trainer->specialization }}" style="animation-delay: {{ 0.1 * $loop->index + 0.5 }}s">
                <a href="{{ route('trainer.detail', $trainer->id) }}" class="block">
                    <article class="trainer-card group">
                        <div class="card-img-wrap">
                            <img src="{{ $trainer->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($trainer->user->name).'&background=FF6B35&color=fff&size=500' }}" 
                                 alt="{{ $trainer->user->name }}" class="card-img">
                            <div class="overlay-glow"></div>
                            <div class="absolute top-8 right-8">
                                <span class="bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">
                                    Certified Coach
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <span class="spec-tag">{{ $trainer->specialization == 'both' ? 'Hybrid Coach' : $trainer->specialization }} Master</span>
                            <h3 class="name-text">{{ $trainer->user->name }}</h3>
                            <p class="bio-text">
                                Chuyên gia đào tạo với hơn 5 năm kinh nghiệm thực chiến. Giúp hơn 200+ học viên thay đổi hình thể hoàn toàn.
                            </p>
                            <div class="btn-book">
                                <span>CHI TIẾT & ĐẶT LỊCH PT</span>
                                <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-2"></i>
                            </div>
                        </div>
                    </article>
                </a>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <p class="text-slate-500 text-sm font-bold uppercase tracking-widest">Hiện chưa có HLV vào danh sách này.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const trainerCards = document.querySelectorAll('.trainer-card-wrapper');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Active class
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.getAttribute('data-filter');

                trainerCards.forEach(card => {
                    const spec = card.getAttribute('data-specialization');
                    if (filter === 'all' || spec === filter) {
                        card.style.display = 'block';
                        setTimeout(() => card.style.opacity = '1', 10);
                    } else {
                        card.style.opacity = '0';
                        setTimeout(() => card.style.display = 'none', 300);
                    }
                });
            });
        });
    });
</script>
@endsection
