@extends('layouts.client')

@section('title', 'Gói Tập — EXTRA FIT+ GYM & FITNESS')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<style>
    .packages-hero {
        background: linear-gradient(rgba(26, 26, 46, 0.8), rgba(26, 26, 46, 0.8)), 
                    url('https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=1600&q=80&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        padding: var(--space-10) 0;
        text-align: center;
        color: #fff;
        margin-bottom: var(--space-6);
    }
    .packages-hero h1 {
        font-size: clamp(32px, 5vw, 56px);
        font-weight: 900;
        margin-bottom: var(--space-2);
    }
    .packages-hero p {
        font-size: var(--font-size-lg);
        color: rgba(255,255,255,0.8);
        max-width: 600px;
        margin: 0 auto;
    }
</style>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
    <li class="breadcrumb-item active">Gói tập</li>
</ol>
@endsection

@section('content')
<section class="packages-hero">
    <div class="container animate-on-scroll">
        <h1>Gói Tập Của Chúng Tôi</h1>
        <p>Tìm gói tập phù hợp nhất với mục tiêu sức khỏe và phong cách sống của bạn.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Lựa chọn của bạn</span>
            <h2 class="section-title">Các Gói <span>Thành Viên</span></h2>
            <p class="section-desc">Từ người mới bắt đầu đến vận động viên chuyên nghiệp, chúng tôi đều có kế hoạch hoàn hảo dành cho bạn.</p>
        </div>

        <div class="pricing-grid">
            @forelse($memberships as $membership)
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
                        <li><i class="fas fa-check-circle"></i> Tập tất cả các bộ môn</li>
                    @endif
                </ul>
                <div class="pricing-action">
                    @auth
                        <a href="{{ route('payment.checkout', ['package' => $membership->id]) }}" class="btn {{ $membership->category == 'VIP' ? 'btn-primary' : 'btn-outline-primary' }} w-full">
                            Đăng ký ngay
                        </a>
                    @else
                        <a href="{{ route('register', ['package' => $membership->id]) }}" class="btn {{ $membership->category == 'VIP' ? 'btn-primary' : 'btn-outline-primary' }} w-full">
                            Đăng ký ngay
                        </a>
                    @endauth
                </div>
            </div>
            @empty
            <div class="text-center w-full" style="grid-column: 1/-1; padding: var(--space-10) 0;">
                <i class="fas fa-dumbbell fa-3x" style="color: var(--color-border); margin-bottom: 20px;"></i>
                <p style="color: var(--color-text-muted);">Hiện tại chưa có gói tập nào khả dụng. Vui lòng quay lại sau!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- FAQ Section --}}
<section class="section" style="background: var(--color-surface); border-top: 1px solid var(--color-border);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Câu Hỏi <span>Thường Gặp</span></h2>
        </div>
        <div style="max-width: 800px; margin: 0 auto; display: grid; gap: var(--space-3);">
            <div style="background: var(--color-bg); padding: var(--space-3); border-radius: var(--radius-card); border: 1px solid var(--color-border);">
                <h4 style="margin-bottom: 10px; font-weight: 700;">Tôi có thể đóng băng gói tập không?</h4>
                <p style="color: var(--color-text-muted); font-size: 14px;">Có, tất cả hội viên chính thức đều có thể yêu cầu đóng băng gói tập tối đa 7 ngày nếu có việc bận đột xuất hoặc lý do sức khỏe.</p>
            </div>
            <div style="background: var(--color-bg); padding: var(--space-3); border-radius: var(--radius-card); border: 1px solid var(--color-border);">
                <h4 style="margin-bottom: 10px; font-weight: 700;">Tôi mới bắt đầu thì nên chọn gói nào?</h4>
                <p style="color: var(--color-text-muted); font-size: 14px;">Nếu bạn chưa có kinh nghiệm, gói VIP hoặc gói có kèm buổi PT sẽ là lựa chọn tốt nhất để được hướng dẫn kỹ thuật cơ bản đúng cách.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Reveal animation logic (already in main.js usually, but ensuring it runs for dynamic items)
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('reveal');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    });
</script>
@endsection
