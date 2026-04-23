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

    /* Confirmation Modal */
    .confirm-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(6px);
        z-index: 9999;
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden;
        transition: all 0.3s ease;
    }
    .confirm-overlay.active { opacity: 1; visibility: visible; }
    .confirm-overlay.active .confirm-box { transform: scale(1) translateY(0); }

    .confirm-box {
        background: #fff;
        border-radius: 20px;
        padding: 40px 36px 32px;
        max-width: 440px; width: 92%;
        text-align: center;
        box-shadow: 0 24px 80px rgba(0,0,0,0.25);
        transform: scale(0.9) translateY(20px);
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .confirm-icon {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FF6B35, #FF8C5A);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px; color: #fff;
    }
    .confirm-title {
        font-size: 22px; font-weight: 800;
        color: #1A1A2E; margin-bottom: 8px;
    }
    .confirm-desc {
        font-size: 15px; color: #666;
        margin-bottom: 20px; line-height: 1.5;
    }
    .confirm-package-info {
        background: #f8f8fa;
        border-radius: 14px;
        padding: 20px; margin-bottom: 24px;
        border: 1px solid #eee;
    }
    .confirm-package-name {
        font-size: 18px; font-weight: 700;
        color: #1A1A2E; margin-bottom: 6px;
    }
    .confirm-package-price {
        font-size: 26px; font-weight: 900;
        color: #FF6B35;
    }
    .confirm-package-price small {
        font-size: 14px; font-weight: 500;
        color: #999;
    }
    .confirm-actions {
        display: flex; gap: 12px;
    }
    .confirm-actions .btn {
        flex: 1; padding: 14px 20px;
        border-radius: 12px; font-weight: 700;
        font-size: 15px; cursor: pointer;
        transition: all 0.2s;
    }
    .confirm-btn-cancel {
        background: #f0f0f0; color: #555;
        border: none;
    }
    .confirm-btn-cancel:hover { background: #e4e4e4; }
    .confirm-btn-ok {
        background: linear-gradient(135deg, #FF6B35, #FF8C5A);
        color: #fff; border: none;
        box-shadow: 0 4px 16px rgba(255,107,53,0.35);
    }
    .confirm-btn-ok:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 24px rgba(255,107,53,0.45);
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

        @if(session('error'))
            <div style="background: #FFF1F0; border: 1px solid #FFA39E; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px; color: #CF1322; font-weight: 600;">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div style="background: #F6FFED; border: 1px solid #B7EB8F; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px; color: #389E0D; font-weight: 600;">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

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
                        <button onclick="confirmPackage('{{ $membership->name }}', '{{ number_format($membership->price, 0, ',', '.') }}đ / {{ $membership->duration_days }} ngày', '{{ route('payment.checkout', ['package' => $membership->id]) }}')"
                                class="btn {{ $membership->category == 'VIP' ? 'btn-primary' : 'btn-outline-primary' }} w-full">
                            Đăng ký ngay
                        </button>
                    @else
                        <a href="{{ route('login', ['package' => $membership->id]) }}" class="btn {{ $membership->category == 'VIP' ? 'btn-primary' : 'btn-outline-primary' }} w-full">
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
                <h4 style="margin-bottom: 10px; font-weight: 700;">Tôi có thể gia hạn gói tập không?</h4>
                <p style="color: var(--color-text-muted); font-size: 14px;">Có, tất cả hội viên đều có thể gia hạn gói tập bất kỳ lúc nào. Thời hạn sẽ được cộng thêm vào ngày hết hạn hiện tại.</p>
            </div>
            <div style="background: var(--color-bg); padding: var(--space-3); border-radius: var(--radius-card); border: 1px solid var(--color-border);">
                <h4 style="margin-bottom: 10px; font-weight: 700;">Tôi mới bắt đầu thì nên chọn gói nào?</h4>
                <p style="color: var(--color-text-muted); font-size: 14px;">Nếu bạn chưa có kinh nghiệm, gói VIP hoặc gói có kèm buổi PT sẽ là lựa chọn tốt nhất để được hướng dẫn kỹ thuật cơ bản đúng cách.</p>
            </div>
        </div>
    </div>
</section>
{{-- Confirmation Modal --}}
<div class="confirm-overlay" id="confirmModal">
    <div class="confirm-box">
        <div class="confirm-icon"><i class="fas fa-dumbbell"></i></div>
        <h3 class="confirm-title">Xác nhận đăng ký</h3>
        <p class="confirm-desc">Bạn có chắc chắn muốn đăng ký gói tập này không?</p>
        <div class="confirm-package-info">
            <div class="confirm-package-name" id="confirmPkgName"></div>
            <div class="confirm-package-price" id="confirmPkgPrice"></div>
        </div>
        <div class="confirm-actions">
            <button class="btn confirm-btn-cancel" onclick="closeConfirm()"><i class="fas fa-times"></i> Hủy bỏ</button>
            <a href="#" class="btn confirm-btn-ok" id="confirmPkgLink"><i class="fas fa-check"></i> Đồng ý</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Reveal animation
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

    // Confirmation modal
    function confirmPackage(name, price, url) {
        document.getElementById('confirmPkgName').textContent = name;
        document.getElementById('confirmPkgPrice').innerHTML = price;
        document.getElementById('confirmPkgLink').href = url;
        document.getElementById('confirmModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeConfirm() {
        document.getElementById('confirmModal').classList.remove('active');
        document.body.style.overflow = '';
    }
    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) closeConfirm();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeConfirm();
    });
</script>
@endsection
