@extends('layouts.client')

@section('title', 'Đội Ngũ Huấn Luyện Viên — EXTRA FIT+')

@section('styles')
<style>
    /* Hero Section */
    .trainer-hero {
        position: relative;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=1600&q=80&auto=format&fit=crop') center/cover no-repeat;
        color: #fff;
        margin-bottom: var(--space-8);
    }
    .trainer-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(26,26,46,0.8), rgba(26,26,46,0.4));
    }
    .hero-content-wrap {
        position: relative;
        z-index: 2;
        text-align: center;
    }
    .hero-title {
        font-size: clamp(32px, 5vw, 48px);
        font-weight: 900;
        margin-bottom: var(--space-2);
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .hero-subtitle {
        font-size: var(--font-size-lg);
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Trainer Grid */
    .trainers-page-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: var(--space-4);
        margin-top: var(--space-6);
    }

    /* Filter System */
    .filter-wrap {
        display: flex;
        justify-content: center;
        gap: var(--space-2);
        margin-bottom: var(--space-6);
        flex-wrap: wrap;
    }
    .filter-btn {
        padding: 10px 24px;
        border-radius: var(--radius-badge);
        background: var(--color-surface);
        border: 1.5px solid var(--color-border);
        font-weight: 600;
        transition: all var(--transition-base);
    }
    .filter-btn.active, .filter-btn:hover {
        background: var(--color-primary);
        color: #fff;
        border-color: var(--color-primary);
        box-shadow: var(--shadow-btn);
    }

    /* Trainer Card Premium */
    .trainer-card-wrapper {
        perspective: 1000px;
    }
    .trainer-card-inner {
        position: relative;
        border-radius: var(--radius-card);
        overflow: hidden;
        background: var(--color-surface);
        box-shadow: var(--shadow-card);
        transition: all var(--transition-slow);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .trainer-card-inner:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-card-hover);
    }

    .trainer-img-container {
        position: relative;
        padding-top: 125%; /* 4:5 ratio */
        overflow: hidden;
    }
    .trainer-img-src {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .trainer-card-inner:hover .trainer-img-src {
        transform: scale(1.1);
    }

    .trainer-badge-special {
        position: absolute;
        top: 15px; right: 15px;
        background: rgba(255, 107, 53, 0.9);
        backdrop-filter: blur(4px);
        color: #fff;
        padding: 4px 12px;
        border-radius: var(--radius-badge);
        font-weight: 700;
        font-size: 12px;
        z-index: 3;
    }

    .trainer-details {
        padding: var(--space-3);
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .trainer-name-main {
        font-size: var(--font-size-xl);
        font-weight: 800;
        margin-bottom: 4px;
        color: var(--color-text);
    }
    .trainer-spec-text {
        color: var(--color-primary);
        font-weight: 600;
        font-size: var(--font-size-sm);
        margin-bottom: var(--space-2);
    }
    .trainer-bio {
        font-size: var(--font-size-sm);
        color: var(--color-text-muted);
        margin-bottom: var(--space-3);
        line-height: 1.5;
    }

    .trainer-social-links {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }
    .social-icon {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: var(--color-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-text-muted);
        transition: all var(--transition-base);
    }
    .social-icon:hover {
        background: var(--color-primary);
        color: #fff;
        transform: translateY(-3px);
    }

    [data-theme="dark"] .trainer-card-inner {
        background: #1E1E2E;
        border: 1px solid #2E2E3E;
    }
</style>
@endsection

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="display: flex; gap: 8px; font-size: 14px; padding: 16px 0;">
        <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: var(--color-primary);">Trang chủ</a></li>
        <li class="breadcrumb-item active" style="color: var(--color-text-muted);" aria-current="page"> / Huấn luyện viên</li>
    </ol>
</nav>
@endsection

@section('content')
<section class="trainer-hero">
    <div class="hero-content-wrap container animate-on-scroll">
        <h1 class="hero-title">Đội ngũ Huấn luyện viên</h1>
        <p class="hero-subtitle">Những chuyên gia hàng đầu sẽ đồng hành cùng bạn trên hành trình chinh phục vóc dáng và sức khỏe lý tưởng.</p>
    </div>
</section>

<div class="container pb-10">
    <div class="filter-wrap animate-on-scroll delay-1" id="filterContainer">
        <button class="filter-btn active" data-filter="all">Tất cả HLV</button>
        <button class="filter-btn" data-filter="gym">Thể hình / Gym</button>
        <button class="filter-btn" data-filter="yoga">Yoga chuyên sâu</button>
        <button class="filter-btn" data-filter="both">Đa năng (Gym & Yoga)</button>
    </div>

    <div class="trainers-page-grid" id="trainersGrid">
        @forelse($trainers as $trainer)
        <div class="trainer-card-wrapper animate-on-scroll" data-specialization="{{ $trainer->specialization }}">
            <div class="trainer-card-inner">
                <div class="trainer-img-container">
                    <img src="{{ $trainer->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($trainer->user->name).'&background=FF6B35&color=fff&size=500' }}" 
                         alt="{{ $trainer->user->name }}" class="trainer-img-src" loading="lazy">
                    <div class="trainer-badge-special">
                        {{ $trainer->specialization == 'both' ? 'Gym & Yoga' : ucwords($trainer->specialization) }}
                    </div>
                </div>
                <div class="trainer-details">
                    <div>
                        <h3 class="trainer-name-main">{{ $trainer->user->name }}</h3>
                        <p class="trainer-spec-text">
                            <i class="fas fa-certificate"></i> Chuyên gia {{ $trainer->specialization == 'both' ? 'Gym & Yoga' : ucwords($trainer->specialization) }}
                        </p>
                        <p class="trainer-bio">
                            Đã có hơn 5 năm kinh nghiệm trong việc huấn luyện và thay đổi hình thể cho hàng trăm hội viên thành công.
                        </p>
                    </div>
                    <div class="trainer-social-links">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="mailto:{{ $trainer->user->email }}" class="social-icon"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state w-full py-20" style="grid-column: 1 / -1;">
            <div class="empty-icon"><i class="fas fa-user-slash"></i></div>
            <h3 class="empty-title">Chưa có huấn luyện viên nào</h3>
            <p class="empty-desc">Chúng tôi đang cập nhật danh sách chuyên gia. Vui lòng quay lại sau!</p>
        </div>
        @endforelse
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
