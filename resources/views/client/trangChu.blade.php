@extends('layouts.client')

@section('title', 'EXTRA FIT+ GYM & FITNESS — Nơi Bắt Đầu Hành Trình Của Bạn')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')

{{-- ============================================================
     HERO SECTION — Full-height slider
     ============================================================ --}}
<section class="hero-section" id="heroSection" aria-label="Banner trang chủ">

    {{-- Background Slides --}}
    <div class="hero-slides-wrapper">
        <div class="hero-slide active">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1600&q=80&auto=format&fit=crop"
                 alt="Gym training" class="hero-slide-bg" loading="eager">
        </div>
        <div class="hero-slide">
            <img src="https://images.unsplash.com/photo-1549060279-7e168fcee0c2?w=1600&q=80&auto=format&fit=crop"
                 alt="Boxing training" class="hero-slide-bg" loading="lazy">
        </div>
        <div class="hero-slide">
            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=1600&q=80&auto=format&fit=crop"
                 alt="Yoga fitness" class="hero-slide-bg" loading="lazy">
        </div>
    </div>

    {{-- Decorative Overlay --}}
    <div class="hero-overlay"></div>
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>

    {{-- Main Content --}}
    <div class="hero-content">
        <p class="hero-eyebrow">Elite Personal Training Services</p>
        <h1 class="hero-title">
            Biến Hình <span>Cơ Thể</span><br>
            Của Bạn Ngay Hôm Nay
        </h1>
        <p class="hero-desc">
            Hành trình ngàn dặm bắt đầu từ một bước đi. Hãy để EXTRA FIT+ đồng hành cùng bạn với đội ngũ HLV chuyên nghiệp và cơ sở vật chất hiện đại hàng đầu.
        </p>
        <div class="hero-actions">
            <a href="{{ url('/dang-ky') }}" class="btn btn-primary btn-xl">
                <i class="fas fa-dumbbell"></i> Đăng ký ngay
            </a>
            <a href="{{ url('/lich-lop') }}" class="btn btn-white btn-xl">
                <i class="fas fa-calendar-alt"></i> Xem lịch lớp
            </a>
        </div>

        {{-- Stats --}}
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-num">500<span>+</span></div>
                <div class="hero-stat-label">Hội viên tích cực</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num">20<span>+</span></div>
                <div class="hero-stat-label">Huấn luyện viên</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num">15<span>+</span></div>
                <div class="hero-stat-label">Bộ môn đa dạng</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num">5</div>
                <div class="hero-stat-label">Năm kinh nghiệm</div>
            </div>
        </div>
    </div>

    {{-- Slide Dots --}}
    <div class="hero-dots" role="tablist" aria-label="Slide navigation">
        <button class="hero-dot active" role="tab" aria-label="Slide 1"></button>
        <button class="hero-dot" role="tab" aria-label="Slide 2"></button>
        <button class="hero-dot" role="tab" aria-label="Slide 3"></button>
    </div>

    {{-- Scroll Indicator --}}
    <div class="hero-scroll" aria-hidden="true">
        <span>Cuộn xuống</span>
        <div class="hero-scroll-line"></div>
    </div>
</section>


{{-- ============================================================
     OUR PROGRAM SECTION
     ============================================================ --}}
<section class="section programs-section" id="programSection" aria-labelledby="programTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-tag animate-on-scroll">Chương trình</span>
            <h2 class="section-title animate-on-scroll delay-1" id="programTitle">
                Chương Trình <span>Tập Luyện</span>
            </h2>
            <p class="section-desc animate-on-scroll delay-2">
                Các chuyên gia của chúng tôi sẽ giúp bạn khám phá kỹ thuật và bài tập mới, mang lại hiệu quả toàn diện cho cơ thể.
            </p>
        </div>

        <div class="programs-grid">
            {{-- Weight Lifting --}}
            <div class="program-card animate-on-scroll delay-1" tabindex="0">
                <div class="program-icon-wrap" aria-hidden="true">
                    <i class="fas fa-dumbbell"></i>
                </div>
                <h3 class="program-name">Tập tạ</h3>
                <p class="program-desc">Phát triển sức mạnh cơ bắp, cải thiện thể trạng với các bài tập tạ đa dạng từ cơ bản đến nâng cao.</p>
            </div>

            {{-- Body Building --}}
            <div class="program-card animate-on-scroll delay-2" tabindex="0">
                <div class="program-icon-wrap" aria-hidden="true">
                    <i class="fas fa-fire"></i>
                </div>
                <h3 class="program-name">Thể hình</h3>
                <p class="program-desc">Điêu khắc cơ thể cân đối, tăng cơ giảm mỡ với với chương trình bodybuilding chuyên nghiệp.</p>
            </div>

            {{-- Healthy / Cardio --}}
            <div class="program-card animate-on-scroll delay-3" tabindex="0">
                <div class="program-icon-wrap" aria-hidden="true">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3 class="program-name">Cardio</h3>
                <p class="program-desc">Cải thiện sức bền tim mạch, đốt cháy calo hiệu quả với các bài tập aerobic và cardio cường độ cao.</p>
            </div>

            {{-- Yoga --}}
            <div class="program-card animate-on-scroll delay-4" tabindex="0">
                <div class="program-icon-wrap" aria-hidden="true">
                    <i class="fas fa-spa"></i>
                </div>
                <h3 class="program-name">Yoga</h3>
                <p class="program-desc">Cân bằng thân – tâm – trí với yoga. Tăng độ dẻo dai, giảm căng thẳng, cải thiện chất lượng cuộc sống.</p>
            </div>

            {{-- Boxing --}}
            <div class="program-card animate-on-scroll delay-1" tabindex="0">
                <div class="program-icon-wrap" aria-hidden="true">
                    <i class="fas fa-fist-raised"></i>
                </div>
                <h3 class="program-name">Boxing</h3>
                <p class="program-desc">Luyện tập kỹ năng tự vệ, phản xạ và đốt cháy calo tối đa với các giáo trình boxing chuyên nghiệp.</p>
            </div>

            {{-- Running --}}
            <div class="program-card animate-on-scroll delay-2" tabindex="0">
                <div class="program-icon-wrap" aria-hidden="true">
                    <i class="fas fa-running"></i>
                </div>
                <h3 class="program-name">Chạy bộ</h3>
                <p class="program-desc">Rèn luyện sức bền, tăng cường sức khỏe hô hấp và tim mạch với chương trình chạy bộ khoa học.</p>
            </div>

            {{-- Crossfit --}}
            <div class="program-card animate-on-scroll delay-3" tabindex="0">
                <div class="program-icon-wrap" aria-hidden="true">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="program-name">CrossFit</h3>
                <p class="program-desc">Kết hợp nhiều hình thức vận động, rèn luyện toàn diện cả sức mạnh, sức bền và linh hoạt.</p>
            </div>

            {{-- Swimming --}}
            <div class="program-card animate-on-scroll delay-4" tabindex="0">
                <div class="program-icon-wrap" aria-hidden="true">
                    <i class="fas fa-swimmer"></i>
                </div>
                <h3 class="program-name">Bơi lội</h3>
                <p class="program-desc">Bài tập bơi lội tác động thấp, hiệu quả cao — phù hợp với mọi lứa tuổi và trình độ.</p>
            </div>
        </div>
    </div>
</section>


{{-- ============================================================
     CTA OFFER BANNER
     ============================================================ --}}
<section class="cta-banner" id="ctaBanner" aria-labelledby="ctaTitle">
    <div class="cta-banner-bg"></div>
    <div class="cta-pattern"></div>
    <div class="cta-glow"></div>
    <div class="container">
        <div class="cta-content">
            <p class="section-tag animate-on-scroll" style="color:#FF8C5A;">Ưu đãi đặc biệt</p>
            <h2 class="cta-title animate-on-scroll delay-1" id="ctaTitle">
                Bắt Đầu Hành Trình Với<br>
                <span>Ưu Đãi Hấp Dẫn</span> Ngay Hôm Nay
            </h2>
            <p class="cta-desc animate-on-scroll delay-2">
                Đăng ký ngay hôm nay để nhận tháng đầu tiên với giá ưu đãi 50% và được tư vấn dinh dưỡng miễn phí.
            </p>
            <div class="cta-actions animate-on-scroll delay-3">
                <a href="{{ url('/dang-ky') }}" class="btn btn-primary btn-xl">
                    <i class="fas fa-rocket"></i> Đăng ký ngay
                </a>
                <a href="{{ url('/goi-tap') }}" class="btn btn-outline-primary btn-xl"
                   style="color:#fff;border-color:rgba(255,255,255,0.4);"
                   onmouseenter="this.style.color='#FF6B35';this.style.borderColor='#FF6B35';"
                   onmouseleave="this.style.color='#fff';this.style.borderColor='rgba(255,255,255,0.4)';">
                    <i class="fas fa-tags"></i> Xem gói tập
                </a>
            </div>
        </div>
    </div>
</section>


{{-- ============================================================
     OUR CLASS SECTION
     ============================================================ --}}
<section class="section classes-section" id="classSection" aria-labelledby="classTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-tag animate-on-scroll">Lớp học</span>
            <h2 class="section-title animate-on-scroll delay-1" id="classTitle">
                Các Lớp Học <span>Của Chúng Tôi</span>
            </h2>
            <p class="section-desc animate-on-scroll delay-2">
                Đội ngũ chuyên gia sẽ giúp bạn khám phá kỹ thuật tập luyện mới, mang lại hiệu quả toàn diện cho toàn thân.
            </p>
        </div>

        {{-- Class Filter Tabs --}}
        <div class="classes-tabs animate-on-scroll delay-3">
            <button class="class-tab active" id="tabAll" data-filter="all">Tất cả</button>
            <button class="class-tab" data-filter="gym">Gym</button>
            <button class="class-tab" data-filter="yoga">Yoga</button>
            <button class="class-tab" data-filter="boxing">Boxing</button>
            <button class="class-tab" data-filter="cardio">Cardio</button>
        </div>

        {{-- Classes Layout: List + Detail --}}
        <div class="classes-container animate-on-scroll">
            {{-- Left: List --}}
            <div class="classes-list">
                <div class="class-list-item active" data-class="bodybuilding" id="classItem1">
                    <i class="fas fa-dumbbell text-primary" style="margin-right:8px"></i> Tập thể hình
                </div>
                <div class="class-list-item" data-class="running" id="classItem2">
                    <i class="fas fa-running text-primary" style="margin-right:8px"></i> Chạy đua
                </div>
                <div class="class-list-item" data-class="yoga" id="classItem3">
                    <i class="fas fa-spa text-primary" style="margin-right:8px"></i> Yoga thể dục
                </div>
                <div class="class-list-item" data-class="kickboxing" id="classItem4">
                    <i class="fas fa-fist-raised text-primary" style="margin-right:8px"></i> Kick boxing
                </div>
                <div class="class-list-item" data-class="cardio" id="classItem5">
                    <i class="fas fa-heartbeat text-primary" style="margin-right:8px"></i> Cardio workout
                </div>
                <div class="class-list-item" data-class="martialarts" id="classItem6">
                    <i class="fas fa-user-ninja text-primary" style="margin-right:8px"></i> Võ thuật
                </div>
            </div>

            {{-- Right: Detail --}}
            <div class="class-detail-panel" data-class="bodybuilding" id="detailBodybuilding">
                <div class="class-detail">
                    <img src="https://images.unsplash.com/photo-1583454110551-21f2fa2afe61?w=800&q=80&auto=format&fit=crop"
                         alt="Body Building" class="class-detail-img" loading="lazy">
                    <div class="class-detail-body">
                        <span class="class-detail-tag">Gym · Thể hình</span>
                        <h3 class="class-detail-title">Tập thể hình chuyên nghiệp</h3>
                        <p class="class-detail-desc">Chương trình bodybuilding toàn diện, giúp bạn điêu khắc cơ thể với khối lượng nhẹ và nhiều lần lặp. Đốt mỡ, tăng cơ và tạo hình cơ thể lý tưởng. Phương pháp nhanh nhất để có được cơ thể hoàn hảo.</p>
                        <div class="class-detail-meta">
                            <div class="class-meta-item"><i class="fas fa-clock"></i> 60 phút</div>
                            <div class="class-meta-item"><i class="fas fa-signal"></i> Tất cả trình độ</div>
                            <div class="class-meta-item"><i class="fas fa-fire"></i> 400-600 cal</div>
                        </div>
                        <a href="{{ url('/lich-lop') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Xem lịch lớp
                        </a>
                    </div>
                </div>
            </div>

            <div class="class-detail-panel" data-class="running" id="detailRunning" style="display:none">
                <div class="class-detail">
                    <img src="https://images.unsplash.com/photo-1571008887538-b36bb32f4571?w=800&q=80&auto=format&fit=crop"
                         alt="Running" class="class-detail-img" loading="lazy">
                    <div class="class-detail-body">
                        <span class="class-detail-tag">Cardio · Endurance</span>
                        <h3 class="class-detail-title">Chạy đua & Sức bền</h3>
                        <p class="class-detail-desc">Luyện tập sức bền với chương trình chạy khoa học. Tăng cường hô hấp, tim mạch và đốt cháy năng lượng tối đa. Phù hợp với người mới bắt đầu đến runner chuyên nghiệp.</p>
                        <div class="class-detail-meta">
                            <div class="class-meta-item"><i class="fas fa-clock"></i> 45 phút</div>
                            <div class="class-meta-item"><i class="fas fa-signal"></i> Mọi trình độ</div>
                            <div class="class-meta-item"><i class="fas fa-fire"></i> 350-500 cal</div>
                        </div>
                        <a href="{{ url('/lich-lop') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Xem lịch lớp
                        </a>
                    </div>
                </div>
            </div>

            <div class="class-detail-panel" data-class="yoga" id="detailYoga" style="display:none">
                <div class="class-detail">
                    <img src="https://images.unsplash.com/photo-1545389336-cf090694435e?w=800&q=80&auto=format&fit=crop"
                         alt="Yoga" class="class-detail-img" loading="lazy">
                    <div class="class-detail-body">
                        <span class="class-detail-tag">Yoga · Thiền</span>
                        <h3 class="class-detail-title">Yoga thể dục toàn diện</h3>
                        <p class="class-detail-desc">Cân bằng thân – tâm – trí với yoga. Tăng độ dẻo dai, giảm căng thẳng và cải thiện chất lượng giấc ngủ. Phù hợp mọi lứa tuổi, đặc biệt tốt cho người bận rộn.</p>
                        <div class="class-detail-meta">
                            <div class="class-meta-item"><i class="fas fa-clock"></i> 75 phút</div>
                            <div class="class-meta-item"><i class="fas fa-signal"></i> Tất cả trình độ</div>
                            <div class="class-meta-item"><i class="fas fa-fire"></i> 200-350 cal</div>
                        </div>
                        <a href="{{ url('/lich-lop') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Xem lịch lớp
                        </a>
                    </div>
                </div>
            </div>

            <div class="class-detail-panel" data-class="kickboxing" id="detailKickboxing" style="display:none">
                <div class="class-detail">
                    <img src="https://images.unsplash.com/photo-1599058917765-a780eda07a3e?w=800&q=80&auto=format&fit=crop"
                         alt="Kickboxing" class="class-detail-img" loading="lazy">
                    <div class="class-detail-body">
                        <span class="class-detail-tag">Boxing · Combat</span>
                        <h3 class="class-detail-title">Kick Boxing cường độ cao</h3>
                        <p class="class-detail-desc">Kết hợp boxing và võ đá, đốt cháy calo tối đa trong thời gian ngắn. Giúp rèn luyện phản xạ, sức mạnh và tự tin trong cuộc sống.</p>
                        <div class="class-detail-meta">
                            <div class="class-meta-item"><i class="fas fa-clock"></i> 60 phút</div>
                            <div class="class-meta-item"><i class="fas fa-signal"></i> Trung bình – Nâng cao</div>
                            <div class="class-meta-item"><i class="fas fa-fire"></i> 500-700 cal</div>
                        </div>
                        <a href="{{ url('/lich-lop') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Xem lịch lớp
                        </a>
                    </div>
                </div>
            </div>

            <div class="class-detail-panel" data-class="cardio" id="detailCardio" style="display:none">
                <div class="class-detail">
                    <img src="https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800&q=80&auto=format&fit=crop"
                         alt="Cardio" class="class-detail-img" loading="lazy">
                    <div class="class-detail-body">
                        <span class="class-detail-tag">Cardio · HIIT</span>
                        <h3 class="class-detail-title">Cardio Workout / HIIT</h3>
                        <p class="class-detail-desc">Bài tập cường độ cao ngắt quãng (HIIT) kết hợp aerobic giúp đốt cháy mỡ tối đa, tăng tốc độ trao đổi chất. Kết quả hiệu quả trong thời gian ngắn nhất.</p>
                        <div class="class-detail-meta">
                            <div class="class-meta-item"><i class="fas fa-clock"></i> 45 phút</div>
                            <div class="class-meta-item"><i class="fas fa-signal"></i> Tất cả trình độ</div>
                            <div class="class-meta-item"><i class="fas fa-fire"></i> 450-650 cal</div>
                        </div>
                        <a href="{{ url('/lich-lop') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Xem lịch lớp
                        </a>
                    </div>
                </div>
            </div>

            <div class="class-detail-panel" data-class="martialarts" id="detailMartialarts" style="display:none">
                <div class="class-detail">
                    <img src="https://images.unsplash.com/photo-1555597673-b21d5c935865?w=800&q=80&auto=format&fit=crop"
                         alt="Martial Arts" class="class-detail-img" loading="lazy">
                    <div class="class-detail-body">
                        <span class="class-detail-tag">Võ thuật · MMA</span>
                        <h3 class="class-detail-title">Võ thuật tổng hợp (MMA)</h3>
                        <p class="class-detail-desc">Luyện tập võ thuật tổng hợp — kết hợp kỹ thuật từ nhiều môn võ khác nhau. Rèn thể lực, kỹ năng chiến đấu và tinh thần thép trong từng buổi học.</p>
                        <div class="class-detail-meta">
                            <div class="class-meta-item"><i class="fas fa-clock"></i> 90 phút</div>
                            <div class="class-meta-item"><i class="fas fa-signal"></i> Tất cả trình độ</div>
                            <div class="class-meta-item"><i class="fas fa-fire"></i> 550-750 cal</div>
                        </div>
                        <a href="{{ url('/lich-lop') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-check"></i> Xem lịch lớp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center" style="margin-top:var(--space-4)">
            <a href="{{ url('/lich-lop') }}" class="btn btn-outline-primary btn-lg animate-on-scroll">
                <i class="fas fa-calendar-alt"></i> Xem toàn bộ lịch lớp
            </a>
        </div>
    </div>
</section>


{{-- ============================================================
     STATS / COUNTER SECTION
     ============================================================ --}}
<section class="counter-section" id="counterSection" aria-label="Thống kê">
    <div class="counter-pattern"></div>
    <div class="container">
        <div class="counter-grid">
            <div class="counter-item animate-on-scroll">
                <div class="counter-num">
                    <span data-counter data-target="500" id="counter1">0</span>
                    <span class="counter-plus">+</span>
                </div>
                <div class="counter-label">Hội viên</div>
            </div>
            <div class="counter-item animate-on-scroll delay-1">
                <div class="counter-num">
                    <span data-counter data-target="20" id="counter2">0</span>
                    <span class="counter-plus">+</span>
                </div>
                <div class="counter-label">Huấn luyện viên</div>
            </div>
            <div class="counter-item animate-on-scroll delay-2">
                <div class="counter-num">
                    <span data-counter data-target="15" id="counter3">0</span>
                    <span class="counter-plus">+</span>
                </div>
                <div class="counter-label">Bộ môn</div>
            </div>
            <div class="counter-item animate-on-scroll delay-3">
                <div class="counter-num">
                    <span data-counter data-target="5" id="counter4">0</span>
                </div>
                <div class="counter-label">Năm kinh nghiệm</div>
            </div>
        </div>
    </div>
</section>


{{-- ============================================================
     PRICING / MEMBERSHIP PACKAGES SECTION
     ============================================================ --}}
<section class="section pricing-section" id="pricingSection" aria-labelledby="pricingTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-tag animate-on-scroll">Bảng giá</span>
            <h2 class="section-title animate-on-scroll delay-1" id="pricingTitle">
                Chọn <span>Gói Tập</span> Phù Hợp
            </h2>
            <p class="section-desc animate-on-scroll delay-2">
                Chúng tôi cung cấp nhiều lựa chọn linh hoạt để bạn bắt đầu hành trình thay đổi bản thân một cách dễ dàng nhất.
            </p>
        </div>

        <div class="pricing-grid">
            @foreach($memberships as $membership)
            <div class="pricing-card animate-on-scroll {{ $membership->category == 'VIP' ? 'popular' : '' }}">
                @if($membership->category == 'VIP')
                    <div class="pricing-badge">Phổ biến nhất</div>
                @endif
                <h3 class="pricing-name">{{ $membership->name }}</h3>
                <div class="pricing-price">
                    <span class="amount">{{ number_format($membership->price, 0, ',', '.') }}</span>
                    <span class="unit">đ / {{ $membership->duration_days }} ngày</span>
                </div>
                <ul class="pricing-features">
                    <li><i class="fas fa-check-circle"></i> Tập luyện không giới hạn</li>
                    <li><i class="fas fa-check-circle"></i> Đầy đủ trang thiết bị</li>
                    <li>
                        <i class="fas {{ $membership->allow_pt ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                        {{ $membership->pt_sessions }} buổi PT hướng dẫn
                    </li>
                    <li><i class="fas fa-check-circle"></i> Tủ đồ & Phòng tắm nóng lạnh</li>
                    @if($membership->category == 'VIP')
                        <li><i class="fas fa-check-circle"></i> Ưu tiên đặt lịch PT</li>
                        <li><i class="fas fa-check-circle"></i> Nước uống miễn phí</li>
                    @endif
                </ul>
                <div class="pricing-action">
                    <a href="{{ url('/dang-ky?package=' . $membership->id) }}" class="btn {{ $membership->category == 'VIP' ? 'btn-primary' : 'btn-outline-primary' }} w-full">
                        Đăng ký gói này
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center" style="margin-top:var(--space-4)">
            <a href="{{ route('client.memberships') }}" class="btn btn-link animate-on-scroll">
                Xem tất cả các loại gói tập <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>


{{-- ============================================================
     OUR TRAINER SECTION
     ============================================================ --}}
<section class="section trainers-section" id="trainerSection" aria-labelledby="trainerTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-tag animate-on-scroll">Đội ngũ</span>
            <h2 class="section-title animate-on-scroll delay-1" id="trainerTitle">
                Huấn Luyện Viên <span>Của Chúng Tôi</span>
            </h2>
            <p class="section-desc animate-on-scroll delay-2">
                Đội ngũ HLV chuyên nghiệp với chứng chỉ quốc tế, sẵn sàng đồng hành và truyền lửa cho từng học viên.
            </p>
        </div>

        {{-- Trainer Filter --}}
        <div class="trainers-filter animate-on-scroll delay-3">
            <button class="trainer-filter-btn active" data-filter="all" id="filterAll">Tất cả</button>
            <button class="trainer-filter-btn" data-filter="gym"   id="filterGym">Gym</button>
            <button class="trainer-filter-btn" data-filter="yoga"  id="filterYoga">Yoga</button>
            <button class="trainer-filter-btn" data-filter="boxing" id="filterBoxing">Boxing</button>
            <button class="trainer-filter-btn" data-filter="cardio" id="filterCardio">Cardio</button>
        </div>

        <div class="trainers-grid" id="trainersGrid">
            {{-- Trainer 1 --}}
            <article class="trainer-card animate-on-scroll delay-1" data-discipline="gym" id="trainerCard1">
                <div class="trainer-img-wrap">
                    <img src="https://images.unsplash.com/photo-1567013127542-490d757e51cd?w=500&q=80&auto=format&fit=crop&face"
                         alt="HLV Nguyễn Minh Tuấn" class="trainer-img" loading="lazy">
                    <span class="trainer-badge">Gym</span>
                    <div class="trainer-overlay">
                        <div class="trainer-social">
                            <a href="#" class="trainer-social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="trainer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ url('/huan-luyen-vien/1') }}" class="trainer-social-link" aria-label="Profile"><i class="fas fa-user"></i></a>
                        </div>
                    </div>
                </div>
                <div class="trainer-info">
                    <h3 class="trainer-name">Nguyễn Minh Tuấn</h3>
                    <p class="trainer-spec">Chuyên gia Tập tạ & Thể hình · 7 năm kinh nghiệm</p>
                    <div class="trainer-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-num">4.9</span>
                        <span class="rating-count">(128 đánh giá)</span>
                    </div>
                </div>
            </article>

            {{-- Trainer 2 --}}
            <article class="trainer-card animate-on-scroll delay-2" data-discipline="yoga" id="trainerCard2">
                <div class="trainer-img-wrap">
                    <img src="https://images.unsplash.com/photo-1548690312-e3b507d8c110?w=500&q=80&auto=format&fit=crop"
                         alt="HLV Trần Thị Lan" class="trainer-img" loading="lazy">
                    <span class="trainer-badge">Yoga</span>
                    <div class="trainer-overlay">
                        <div class="trainer-social">
                            <a href="#" class="trainer-social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="trainer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ url('/huan-luyen-vien/2') }}" class="trainer-social-link" aria-label="Profile"><i class="fas fa-user"></i></a>
                        </div>
                    </div>
                </div>
                <div class="trainer-info">
                    <h3 class="trainer-name">Trần Thị Lan</h3>
                    <p class="trainer-spec">Chuyên gia Yoga & Thiền định · 5 năm kinh nghiệm</p>
                    <div class="trainer-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-num">4.8</span>
                        <span class="rating-count">(95 đánh giá)</span>
                    </div>
                </div>
            </article>

            {{-- Trainer 3 --}}
            <article class="trainer-card animate-on-scroll delay-3" data-discipline="boxing" id="trainerCard3">
                <div class="trainer-img-wrap">
                    <img src="https://images.unsplash.com/photo-1534367507873-d2d7e24c797f?w=500&q=80&auto=format&fit=crop"
                         alt="HLV Lê Văn Hùng" class="trainer-img" loading="lazy">
                    <span class="trainer-badge">Boxing</span>
                    <div class="trainer-overlay">
                        <div class="trainer-social">
                            <a href="#" class="trainer-social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="trainer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ url('/huan-luyen-vien/3') }}" class="trainer-social-link" aria-label="Profile"><i class="fas fa-user"></i></a>
                        </div>
                    </div>
                </div>
                <div class="trainer-info">
                    <h3 class="trainer-name">Lê Văn Hùng</h3>
                    <p class="trainer-spec">Chuyên gia Boxing & Kickboxing · 8 năm kinh nghiệm</p>
                    <div class="trainer-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-num">4.9</span>
                        <span class="rating-count">(110 đánh giá)</span>
                    </div>
                </div>
            </article>

            {{-- Trainer 4 --}}
            <article class="trainer-card animate-on-scroll delay-1" data-discipline="cardio" id="trainerCard4">
                <div class="trainer-img-wrap">
                    <img src="https://images.unsplash.com/photo-1609899537878-49e9196c5bcd?w=500&q=80&auto=format&fit=crop"
                         alt="HLV Phạm Thu Hà" class="trainer-img" loading="lazy">
                    <span class="trainer-badge">Cardio</span>
                    <div class="trainer-overlay">
                        <div class="trainer-social">
                            <a href="#" class="trainer-social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="trainer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ url('/huan-luyen-vien/4') }}" class="trainer-social-link" aria-label="Profile"><i class="fas fa-user"></i></a>
                        </div>
                    </div>
                </div>
                <div class="trainer-info">
                    <h3 class="trainer-name">Phạm Thu Hà</h3>
                    <p class="trainer-spec">Chuyên gia Cardio & HIIT · 4 năm kinh nghiệm</p>
                    <div class="trainer-rating">
                        <span class="stars">★★★★☆</span>
                        <span class="rating-num">4.7</span>
                        <span class="rating-count">(82 đánh giá)</span>
                    </div>
                </div>
            </article>

            {{-- Trainer 5 --}}
            <article class="trainer-card animate-on-scroll delay-2" data-discipline="gym" id="trainerCard5">
                <div class="trainer-img-wrap">
                    <img src="https://images.unsplash.com/photo-1611672585731-fa10603fb9e0?w=500&q=80&auto=format&fit=crop"
                         alt="HLV Đỗ Quang Minh" class="trainer-img" loading="lazy">
                    <span class="trainer-badge">Gym</span>
                    <div class="trainer-overlay">
                        <div class="trainer-social">
                            <a href="#" class="trainer-social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="trainer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ url('/huan-luyen-vien/5') }}" class="trainer-social-link" aria-label="Profile"><i class="fas fa-user"></i></a>
                        </div>
                    </div>
                </div>
                <div class="trainer-info">
                    <h3 class="trainer-name">Đỗ Quang Minh</h3>
                    <p class="trainer-spec">Chuyên gia CrossFit & Thể hình · 6 năm kinh nghiệm</p>
                    <div class="trainer-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-num">4.8</span>
                        <span class="rating-count">(74 đánh giá)</span>
                    </div>
                </div>
            </article>

            {{-- Trainer 6 --}}
            <article class="trainer-card animate-on-scroll delay-3" data-discipline="yoga" id="trainerCard6">
                <div class="trainer-img-wrap">
                    <img src="https://images.unsplash.com/photo-1518310383802-640c2de311b2?w=500&q=80&auto=format&fit=crop"
                         alt="HLV Nguyễn Bảo Châu" class="trainer-img" loading="lazy">
                    <span class="trainer-badge">Yoga</span>
                    <div class="trainer-overlay">
                        <div class="trainer-social">
                            <a href="#" class="trainer-social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="trainer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ url('/huan-luyen-vien/6') }}" class="trainer-social-link" aria-label="Profile"><i class="fas fa-user"></i></a>
                        </div>
                    </div>
                </div>
                <div class="trainer-info">
                    <h3 class="trainer-name">Nguyễn Bảo Châu</h3>
                    <p class="trainer-spec">Chuyên gia Yoga & Pilates · 6 năm kinh nghiệm</p>
                    <div class="trainer-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-num">4.9</span>
                        <span class="rating-count">(156 đánh giá)</span>
                    </div>
                </div>
            </article>
        </div>

        <div class="text-center" style="margin-top:var(--space-4)">
            <a href="{{ url('/huan-luyen-vien') }}" class="btn btn-outline-primary btn-lg animate-on-scroll">
                <i class="fas fa-users"></i> Xem tất cả HLV
            </a>
        </div>
    </div>
</section>


{{-- ============================================================
     TESTIMONIALS SECTION
     ============================================================ --}}
<section class="section testimonials-section" id="testimonialSection" aria-labelledby="testiTitle">
    <div class="testi-bg-text">REVIEW</div>
    <div class="container">
        <div class="section-header">
            <span class="section-tag animate-on-scroll">Đánh giá</span>
            <h2 class="section-title animate-on-scroll delay-1" id="testiTitle">
                Hội Viên Nói Gì <span>Về Chúng Tôi</span>
            </h2>
            <p class="section-desc animate-on-scroll delay-2">
                Hàng trăm hội viên đã thay đổi cuộc đời với EXTRA FIT+. Dưới đây là những chia sẻ chân thực nhất.
            </p>
        </div>

        <div class="testimonials-slider">
            <div class="testi-track" id="testiTrack">
                {{-- Testimonial 1 --}}
                <div class="testi-card">
                    <div class="testi-quote-icon">"</div>
                    <p class="testi-content">Sau 3 tháng tập tại EXTRA FIT+, tôi đã giảm được 8kg và cảm thấy tự tin hơn bao giờ hết. HLV Tuấn rất nhiệt tình và chuyên nghiệp, luôn điều chỉnh bài tập phù hợp với thể trạng của tôi.</p>
                    <div class="testi-author">
                        <img src="https://ui-avatars.com/api/?name=Minh+Anh&background=FF6B35&color=fff&size=48" alt="Minh Anh" class="testi-avatar">
                        <div>
                            <div class="testi-name">Trần Minh Anh</div>
                            <div class="testi-role">Kỹ sư phần mềm · Hội viên 6 tháng</div>
                            <div class="testi-stars">★★★★★</div>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 2 --}}
                <div class="testi-card">
                    <div class="testi-quote-icon">"</div>
                    <p class="testi-content">Tôi yêu thích lớp Yoga tại đây! Cô Lan dạy rất bài bản, không khí lớp học thoải mái, thân thiện. Sau mỗi buổi học, tôi cảm thấy thư giãn và tràn đầy năng lượng cho cả ngày làm việc.</p>
                    <div class="testi-author">
                        <img src="https://ui-avatars.com/api/?name=Thu+Ha&background=1A1A2E&color=fff&size=48" alt="Thu Hà" class="testi-avatar">
                        <div>
                            <div class="testi-name">Nguyễn Thu Hà</div>
                            <div class="testi-role">Giáo viên · Hội viên 1 năm</div>
                            <div class="testi-stars">★★★★★</div>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 3 --}}
                <div class="testi-card">
                    <div class="testi-quote-icon">"</div>
                    <p class="testi-content">EXTRA FIT+ là quyết định tốt nhất tôi từng làm! Cơ sở vật chất hiện đại, sạch sẽ, giờ mở cửa linh hoạt. Đặc biệt ứng dụng đặt lịch rất tiện, tôi có thể quản lý lịch tập mọi lúc mọi nơi.</p>
                    <div class="testi-author">
                        <img src="https://ui-avatars.com/api/?name=Van+Duc&background=22C55E&color=fff&size=48" alt="Văn Đức" class="testi-avatar">
                        <div>
                            <div class="testi-name">Lê Văn Đức</div>
                            <div class="testi-role">Doanh nhân · Hội viên VIP</div>
                            <div class="testi-stars">★★★★★</div>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 4 --}}
                <div class="testi-card">
                    <div class="testi-quote-icon">"</div>
                    <p class="testi-content">Lớp Kickboxing ở đây thật sự tuyệt vời! Anh Hùng là HLV cực kỳ nhiệt huyết, mỗi buổi học đều đầy năng lượng. Sau 2 tháng, tôi không chỉ giảm cân mà còn tự tin hơn rất nhiều.</p>
                    <div class="testi-author">
                        <img src="https://ui-avatars.com/api/?name=Bao+Tram&background=3B82F6&color=fff&size=48" alt="Bảo Trâm" class="testi-avatar">
                        <div>
                            <div class="testi-name">Đinh Bảo Trâm</div>
                            <div class="testi-role">Sinh viên · Hội viên 4 tháng</div>
                            <div class="testi-stars">★★★★★</div>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 5 --}}
                <div class="testi-card">
                    <div class="testi-quote-icon">"</div>
                    <p class="testi-content">Tôi 45 tuổi và đến đây với nhiều lo lắng. Nhưng tất cả HLV đều rất chu đáo, xây dựng chương trình phù hợp với tuổi tác của tôi. Giờ tôi khỏe hơn, trẻ hơn và hạnh phúc hơn nhiều!</p>
                    <div class="testi-author">
                        <img src="https://ui-avatars.com/api/?name=Kim+Thanh&background=F59E0B&color=fff&size=48" alt="Kim Thanh" class="testi-avatar">
                        <div>
                            <div class="testi-name">Hoàng Kim Thanh</div>
                            <div class="testi-role">Bác sĩ · Hội viên 8 tháng</div>
                            <div class="testi-stars">★★★★★</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-controls">
            <button class="slider-btn" id="testiPrev" aria-label="Trước">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-btn" id="testiNext" aria-label="Tiếp theo">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>


{{-- ============================================================
     LATEST NEWS SECTION
     ============================================================ --}}
<section class="section news-section" id="newsSection" aria-labelledby="newsTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-tag animate-on-scroll">Blog & Tin tức</span>
            <h2 class="section-title animate-on-scroll delay-1" id="newsTitle">
                Tin Tức <span>Mới Nhất</span>
            </h2>
            <p class="section-desc animate-on-scroll delay-2">
                Cập nhật kiến thức tập luyện, dinh dưỡng và lối sống lành mạnh từ đội ngũ chuyên gia của chúng tôi.
            </p>
        </div>

        <div class="news-grid">
            {{-- News 1 --}}
            <article class="news-card animate-on-scroll delay-1">
                <div class="news-thumb-wrap">
                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&q=80&auto=format&fit=crop"
                         alt="5 bí quyết tập gym" class="news-thumb" loading="lazy">
                    <span class="news-cat">Tập luyện</span>
                </div>
                <div class="news-body">
                    <div class="news-meta">
                        <span><i class="far fa-calendar"></i> 28 Tháng 3, 2025</span>
                        <span><i class="far fa-clock"></i> 5 phút đọc</span>
                    </div>
                    <h3 class="news-title">5 Bí quyết tập gym hiệu quả cho người mới bắt đầu</h3>
                    <p class="news-excerpt">Bắt đầu hành trình tập gym có thể khiến nhiều người bỡ ngỡ. Dưới đây là những bí quyết quan trọng giúp bạn...</p>
                    <a href="{{ url('/tin-tuc/1') }}" class="news-read-more">
                        Đọc thêm <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </article>

            {{-- News 2 --}}
            <article class="news-card animate-on-scroll delay-2">
                <div class="news-thumb-wrap">
                    <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=600&q=80&auto=format&fit=crop"
                         alt="Dinh dưỡng tăng cơ" class="news-thumb" loading="lazy">
                    <span class="news-cat">Dinh dưỡng</span>
                </div>
                <div class="news-body">
                    <div class="news-meta">
                        <span><i class="far fa-calendar"></i> 25 Tháng 3, 2025</span>
                        <span><i class="far fa-clock"></i> 7 phút đọc</span>
                    </div>
                    <h3 class="news-title">Chế độ dinh dưỡng tối ưu để tăng cơ giảm mỡ nhanh nhất</h3>
                    <p class="news-excerpt">Tập luyện chăm chỉ là chưa đủ. Dinh dưỡng đúng cách chiếm đến 70% kết quả. Hãy cùng tìm hiểu...</p>
                    <a href="{{ url('/tin-tuc/2') }}" class="news-read-more">
                        Đọc thêm <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </article>

            {{-- News 3 --}}
            <article class="news-card animate-on-scroll delay-3">
                <div class="news-thumb-wrap">
                    <img src="https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=600&q=80&auto=format&fit=crop"
                         alt="Yoga cho người bận rộn" class="news-thumb" loading="lazy">
                    <span class="news-cat">Yoga</span>
                </div>
                <div class="news-body">
                    <div class="news-meta">
                        <span><i class="far fa-calendar"></i> 20 Tháng 3, 2025</span>
                        <span><i class="far fa-clock"></i> 4 phút đọc</span>
                    </div>
                    <h3 class="news-title">Indoor Cycling — Những điều cần biết trước buổi tập đầu tiên</h3>
                    <p class="news-excerpt">Indoor Cycling đang trở thành xu hướng fitness được yêu thích nhất năm 2025. Đây là những gì bạn cần biết...</p>
                    <a href="{{ url('/tin-tuc/3') }}" class="news-read-more">
                        Đọc thêm <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </article>
        </div>

        <div class="text-center" style="margin-top:var(--space-4)">
            <a href="{{ url('/tin-tuc') }}" class="btn btn-outline-primary btn-lg animate-on-scroll">
                <i class="fas fa-newspaper"></i> Xem tất cả bài viết
            </a>
        </div>
    </div>
</section>


{{-- ============================================================
     CONTACT QUICK / CALLBACK SECTION
     ============================================================ --}}
<section class="section" id="callbackSection" style="background: var(--color-surface); border-top: 1px solid var(--color-border);" aria-labelledby="callbackTitle">
    <div class="container">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: var(--space-8); align-items:center;">
            <div class="animate-on-scroll">
                <span class="section-tag">Liên hệ ngay</span>
                <h2 class="section-title" id="callbackTitle" style="text-align:left; margin-top:8px;">
                    Yêu Cầu <span>Tư Vấn</span> Miễn Phí
                </h2>
                <p style="color:var(--color-text-muted); margin-bottom:var(--space-3); line-height:1.8;">
                    Để lại thông tin, chúng tôi sẽ liên hệ lại trong vòng 30 phút để tư vấn chương trình tập luyện phù hợp nhất với bạn.
                </p>
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <div style="display:flex; gap:12px; align-items:center;">
                        <div style="width:44px;height:44px;border-radius:50%;background:rgba(255,107,53,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-phone" style="color:var(--color-primary)"></i>
                        </div>
                        <div>
                            <div style="font-weight:700;">0909 123 456</div>
                            <div style="font-size:13px;color:var(--color-text-muted);">Hỗ trợ 7:00 – 22:00 hàng ngày</div>
                        </div>
                    </div>
                    <div style="display:flex; gap:12px; align-items:center;">
                        <div style="width:44px;height:44px;border-radius:50%;background:rgba(255,107,53,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-map-marker-alt" style="color:var(--color-primary)"></i>
                        </div>
                        <div>
                            <div style="font-weight:700;">123 Đường Thể Thao, Quận 1</div>
                            <div style="font-size:13px;color:var(--color-text-muted);">TP. Hồ Chí Minh</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="animate-on-scroll delay-2">
                <form class="callback-form" id="callbackForm" onsubmit="handleCallbackForm(event)"
                      style="background:var(--color-bg); border:1.5px solid var(--color-border); border-radius:var(--radius-card); padding:var(--space-4);">
                    <h3 style="font-size:var(--font-size-lg); font-weight:800; margin-bottom:var(--space-3);">Gọi lại cho tôi</h3>
                    <div class="form-group">
                        <label class="form-label" for="cbName">Họ và tên <span class="required">*</span></label>
                        <input type="text" id="cbName" class="form-control" placeholder="Nguyễn Văn A" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="cbPhone">Số điện thoại <span class="required">*</span></label>
                        <input type="tel" id="cbPhone" class="form-control" placeholder="0909 123 456" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="cbGoal">Mục tiêu tập luyện</label>
                        <select id="cbGoal" class="form-control">
                            <option value="">-- Chọn mục tiêu --</option>
                            <option>Giảm cân, giảm mỡ</option>
                            <option>Tăng cơ, thể hình</option>
                            <option>Tăng sức bền</option>
                            <option>Yoga / Thư giãn</option>
                            <option>Võ thuật / Tự vệ</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-full" id="cbSubmitBtn">
                        <i class="fas fa-paper-plane"></i>
                        <span class="btn-text">Gửi yêu cầu tư vấn</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Scroll to Top --}}
<button class="scroll-top-btn" id="scrollTopBtn" aria-label="Về đầu trang">
    <i class="fas fa-chevron-up"></i>
</button>

@endsection


@section('scripts')
<script>
function handleCallbackForm(e) {
    e.preventDefault();
    const btn = document.getElementById('cbSubmitBtn');
    btn.classList.add('btn-loading');
    btn.disabled = true;

    // Simulate API call
    setTimeout(() => {
        btn.classList.remove('btn-loading');
        btn.disabled = false;
        document.getElementById('callbackForm').reset();
        showToast('success', 'Gửi thành công!', 'Chúng tôi sẽ liên hệ với bạn trong vòng 30 phút.');
    }, 1500);
}

// Responsive callback section
(function() {
    const grid = document.querySelector('#callbackSection .container > div');
    if (!grid) return;
    function adjust() {
        grid.style.gridTemplateColumns = window.innerWidth <= 768 ? '1fr' : '1fr 1fr';
    }
    window.addEventListener('resize', adjust);
    adjust();
})();
</script>
@endsection
