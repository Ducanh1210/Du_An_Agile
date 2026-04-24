@extends('layouts.client')

@section('title', 'Xác nhận thanh toán — EXTRA FIT+')

@section('styles')
<style>
    /* ============================================================
       CHECKOUT PAGE — PREMIUM REDESIGN
       ============================================================ */

    .checkout-wrapper {
        padding: var(--space-8) 0 var(--space-10);
        background: var(--color-bg);
        min-height: calc(100vh - 80px);
    }

    /* ---- Breadcrumb / Stepper ---- */
    .checkout-stepper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: var(--space-6);
    }
    .stepper-step {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 600;
        color: var(--color-text-muted);
    }
    .stepper-step.completed {
        color: var(--color-success);
    }
    .stepper-step.active {
        color: var(--color-primary);
    }
    .stepper-dot {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        border: 2px solid var(--color-border);
        background: var(--color-surface);
        color: var(--color-text-muted);
        transition: all 0.3s ease;
    }
    .stepper-step.completed .stepper-dot {
        background: var(--color-success);
        border-color: var(--color-success);
        color: #fff;
    }
    .stepper-step.active .stepper-dot {
        background: var(--color-primary);
        border-color: var(--color-primary);
        color: #fff;
        box-shadow: 0 0 0 4px rgba(255,107,53,0.2);
    }
    .stepper-line {
        width: 60px;
        height: 2px;
        background: var(--color-border);
        margin: 0 12px;
    }
    .stepper-line.done {
        background: var(--color-success);
    }

    /* ---- Header ---- */
    .checkout-header {
        text-align: center;
        margin-bottom: var(--space-6);
    }
    .checkout-title {
        font-size: clamp(26px, 4vw, 38px);
        font-weight: 900;
        color: var(--color-text);
        letter-spacing: -0.5px;
    }
    .checkout-title span {
        background: linear-gradient(135deg, var(--color-primary), #FF9A5C);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .checkout-subtitle {
        color: var(--color-text-muted);
        margin-top: 8px;
        font-size: 15px;
    }

    /* ---- Grid Layout ---- */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--space-5);
    }
    @media (min-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1.6fr 1fr;
            align-items: start;
        }
    }

    /* ---- Package Info Card ---- */
    .checkout-panel {
        background: var(--color-surface);
        border-radius: var(--radius-card);
        border: 1px solid var(--color-border);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        transition: box-shadow 0.3s ease;
    }
    .checkout-panel:hover {
        box-shadow: var(--shadow-card-hover);
    }
    .panel-header {
        background: linear-gradient(135deg, var(--color-primary) 0%, #FF9A5C 100%);
        padding: 20px var(--space-4);
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .panel-header-icon {
        width: 44px;
        height: 44px;
        background: rgba(255,255,255,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
        backdrop-filter: blur(8px);
    }
    .panel-header-text h3 {
        color: #fff;
        font-size: var(--font-size-lg);
        font-weight: 700;
    }
    .panel-header-text p {
        color: rgba(255,255,255,0.8);
        font-size: 13px;
        margin-top: 2px;
    }

    .panel-body {
        padding: var(--space-4);
    }

    /* Package name badge */
    .package-name-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, rgba(255,107,53,0.08), rgba(255,154,92,0.08));
        border: 1px solid rgba(255,107,53,0.15);
        border-radius: var(--radius-badge);
        padding: 6px 16px;
        font-size: 15px;
        font-weight: 700;
        color: var(--color-primary);
        margin-bottom: var(--space-3);
    }
    .package-name-badge i {
        font-size: 14px;
    }

    /* Info rows */
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid var(--color-border);
        transition: background 0.2s ease;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-item:hover {
        background: rgba(255,107,53,0.02);
        margin: 0 -16px;
        padding-left: 16px;
        padding-right: 16px;
        border-radius: 8px;
    }
    .info-label {
        color: var(--color-text-muted);
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .info-label i {
        width: 32px;
        height: 32px;
        background: rgba(255,107,53,0.08);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-primary);
        font-size: 14px;
    }
    .info-value {
        font-weight: 600;
        color: var(--color-text);
        font-size: 15px;
    }

    /* ---- Warning Box ---- */
    .warning-box {
        background: linear-gradient(135deg, rgba(255,107,53,0.06), rgba(255,107,53,0.02));
        border: 1px solid rgba(255,107,53,0.15);
        border-radius: var(--radius-card);
        padding: 20px;
        display: flex;
        gap: 16px;
        margin-top: var(--space-4);
        transition: all 0.3s ease;
    }
    .warning-box:hover {
        border-color: rgba(255,107,53,0.3);
    }
    .warning-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, var(--color-primary), #FF9A5C);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 18px;
        flex-shrink: 0;
    }
    .warning-content h4 {
        color: var(--color-text);
        font-weight: 700;
        font-size: 15px;
        margin-bottom: 4px;
    }
    .warning-content p {
        color: var(--color-text-muted);
        font-size: 13px;
        line-height: 1.6;
    }

    /* ---- Security Badges ---- */
    .security-badges {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
        margin-top: var(--space-4);
        padding: 16px;
        background: var(--color-surface);
        border-radius: var(--radius-card);
        border: 1px solid var(--color-border);
    }
    .security-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--color-text-muted);
        font-weight: 500;
    }
    .security-badge i {
        color: var(--color-success);
        font-size: 14px;
    }

    /* ---- Summary Card (Dark) ---- */
    .summary-card {
        background: linear-gradient(160deg, #1A1A2E 0%, #16213E 50%, #1A1A2E 100%);
        border-radius: var(--radius-card);
        padding: 0;
        position: sticky;
        top: 100px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(26,26,46,0.3);
    }
    .summary-header {
        padding: var(--space-4) var(--space-4) 0;
    }
    .summary-header h3 {
        color: #fff;
        font-size: var(--font-size-xl);
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .summary-header h3 i {
        color: var(--color-primary);
    }

    .summary-body {
        padding: var(--space-3) var(--space-4);
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        color: rgba(255,255,255,0.5);
        font-size: 14px;
    }
    .summary-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        margin: 4px 0;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding: var(--space-2) 0 0;
    }
    .summary-total .label {
        font-weight: 700;
        color: rgba(255,255,255,0.7);
        font-size: 15px;
    }
    .summary-total .value {
        font-size: 32px;
        font-weight: 900;
        background: linear-gradient(135deg, var(--color-primary), #FF9A5C);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }

    /* Actions */
    .summary-actions {
        padding: 0 var(--space-4) var(--space-4);
    }

    .btn-vnpay {
        width: 100%;
        padding: 16px;
        border: none;
        border-radius: var(--radius-btn);
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--color-primary) 0%, #FF9A5C 100%);
        color: #fff;
        box-shadow: 0 4px 20px rgba(255,107,53,0.4);
    }
    .btn-vnpay:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(255,107,53,0.5);
    }
    .btn-vnpay:active {
        transform: translateY(0);
    }
    .btn-vnpay .vnpay-btn-logo {
        height: 22px;
        width: auto;
    }

    .btn-back {
        width: 100%;
        padding: 14px;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: var(--radius-btn);
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: rgba(255,255,255,0.6);
        background: transparent;
        margin-top: 10px;
        font-size: 14px;
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.06);
        border-color: rgba(255,255,255,0.2);
        color: #fff;
    }

    /* VNPay Partner Section */
    .vnpay-partner {
        margin-top: var(--space-3);
        padding: 16px var(--space-4) var(--space-4);
        border-top: 1px solid rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .vnpay-partner span {
        color: rgba(255,255,255,0.3);
        font-size: 12px;
        font-weight: 500;
    }
    .vnpay-partner svg {
        opacity: 0.5;
        transition: opacity 0.3s ease;
    }
    .vnpay-partner:hover svg {
        opacity: 0.8;
    }

    /* ---- Animations ---- */
    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.5s ease forwards;
    }
    .fade-up-delay-1 { animation-delay: 0.1s; }
    .fade-up-delay-2 { animation-delay: 0.2s; }
    .fade-up-delay-3 { animation-delay: 0.3s; }
    .fade-up-delay-4 { animation-delay: 0.4s; }

    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(255,107,53,0.4); }
        50% { box-shadow: 0 0 0 8px rgba(255,107,53,0); }
    }

    .btn-vnpay {
        animation: pulse 2.5s ease infinite;
    }
    .btn-vnpay:hover {
        animation: none;
    }

    /* ---- Responsive ---- */
    @media (max-width: 768px) {
        .checkout-wrapper {
            padding: var(--space-4) 0 var(--space-6);
        }
        .checkout-stepper {
            display: none;
        }
        .stepper-step span {
            display: none;
        }
        .stepper-line {
            width: 30px;
        }
        .security-badges {
            flex-wrap: wrap;
            gap: 12px;
        }
        .summary-card {
            position: static;
        }
    }

    /* ---- Dark mode adjustments ---- */
    [data-theme="dark"] .checkout-panel {
        background: var(--color-surface);
    }
    [data-theme="dark"] .warning-box {
        background: rgba(255,107,53,0.05);
    }
    [data-theme="dark"] .warning-content h4 {
        color: var(--color-primary-light);
    }
    [data-theme="dark"] .security-badges {
        background: var(--color-surface);
    }
    [data-theme="dark"] .info-label i {
        background: rgba(255,107,53,0.12);
    }
</style>
@endsection

@section('content')
<div class="checkout-wrapper">
    <div class="container" style="max-width: 1040px;">

        {{-- Stepper --}}
        <div class="checkout-stepper fade-up">
            <div class="stepper-step completed">
                <div class="stepper-dot"><i class="fa-solid fa-check" style="font-size:14px"></i></div>
                <span>Chọn gói</span>
            </div>
            <div class="stepper-line done"></div>
            <div class="stepper-step active">
                <div class="stepper-dot">2</div>
                <span>Thanh toán</span>
            </div>
            <div class="stepper-line"></div>
            <div class="stepper-step">
                <div class="stepper-dot">3</div>
                <span>Hoàn tất</span>
            </div>
        </div>

        {{-- Header --}}
        <div class="checkout-header fade-up fade-up-delay-1">
            <h1 class="checkout-title">Xác nhận <span>Thanh toán</span></h1>
            <p class="checkout-subtitle">Kiểm tra thông tin gói tập trước khi tiến hành thanh toán an toàn qua VNPay.</p>
        </div>

        @if(session('error'))
            <div style="background: #FFF1F0; border: 1px solid #FFA39E; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px; color: #CF1322; font-weight: 600;" class="fade-up">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="checkout-grid">
            {{-- Left Column --}}
            <div class="checkout-main">
                {{-- Package Details --}}
                <div class="checkout-panel fade-up fade-up-delay-2">
                    <div class="panel-header">
                        <div class="panel-header-icon">
                            <i class="fa-solid fa-dumbbell"></i>
                        </div>
                        <div class="panel-header-text">
                            <h3>Thông tin gói tập</h3>
                            <p>Chi tiết gói bạn đã chọn</p>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="package-name-badge">
                            <i class="fa-solid fa-fire"></i>
                            {{ $membership->name }}
                        </div>

                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    Thời hạn sử dụng
                                </span>
                                <span class="info-value">{{ $membership->duration_days }} ngày</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">
                                    <i class="fa-solid fa-user-tie"></i>
                                    Buổi PT đi kèm
                                </span>
                                <span class="info-value">{{ $membership->pt_sessions ?? 0 }} buổi</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">
                                    <i class="fa-solid fa-user"></i>
                                    Người đăng ký
                                </span>
                                <span class="info-value">{{ auth()->user()->name }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">
                                    <i class="fa-solid fa-envelope"></i>
                                    Email
                                </span>
                                <span class="info-value">{{ auth()->user()->email }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Warning --}}
                <div class="warning-box fade-up fade-up-delay-3">
                    <div class="warning-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="warning-content">
                        <h4>Lưu ý quan trọng</h4>
                        <p>Gói tập sẽ được kích hoạt ngay sau khi thanh toán thành công. Dịch vụ không hỗ trợ hoàn tiền sau khi đã kích hoạt gói. Vui lòng kiểm tra kỹ thông tin trước khi thanh toán.</p>
                    </div>
                </div>

                {{-- Security badges --}}
                <div class="security-badges fade-up fade-up-delay-4">
                    <div class="security-badge">
                        <i class="fa-solid fa-lock"></i>
                        <span>SSL Encrypted</span>
                    </div>
                    <div class="security-badge">
                        <i class="fa-solid fa-shield-check"></i>
                        <span>Bảo mật 256-bit</span>
                    </div>
                    <div class="security-badge">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>Thanh toán an toàn</span>
                    </div>
                </div>
            </div>

            {{-- Right Column — Summary --}}
            <div class="checkout-sidebar fade-up fade-up-delay-3">
                <div class="summary-card">
                    <div class="summary-header">
                        <h3>
                            <i class="fa-solid fa-receipt"></i>
                            Tổng cộng
                        </h3>
                    </div>

                    <div class="summary-body">
                        <div class="summary-item">
                            <span>Giá gói tập</span>
                            <span>{{ number_format($membership->price, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="summary-item">
                            <span>Phí dịch vụ</span>
                            <span>Miễn phí</span>
                        </div>
                        <div class="summary-item">
                            <span>Khuyến mãi</span>
                            <span>—</span>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-total">
                            <span class="label">Thành tiền</span>
                            <span class="value">{{ number_format($membership->price, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <div class="summary-actions">
                        <form action="{{ route('payment.vnpay') }}" method="POST" id="checkoutForm">
                            @csrf
                            <input type="hidden" name="membership_id" value="{{ $membership->id }}">
                            
                            <div style="margin-bottom: 20px; text-align: left;">
                                <label style="color: rgba(255,255,255,0.7); font-size: 13px; font-weight: 600; margin-bottom: 8px; display: block;">Số điện thoại nhận thông báo</label>
                                <input type="text" name="phone" value="{{ auth()->user()->phone }}" placeholder="Nhập số điện thoại..." style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 12px; color: #fff; outline: none;">
                                @error('phone') <span style="color: #ff4d4f; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                            </div>

                            <div style="margin-bottom: 24px; text-align: left;">
                                <label style="color: rgba(255,255,255,0.7); font-size: 13px; font-weight: 600; margin-bottom: 8px; display: block;">Địa chỉ của bạn</label>
                                <input type="text" name="address" placeholder="Nhập địa chỉ..." style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 12px; color: #fff; outline: none;">
                                @error('address') <span style="color: #ff4d4f; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn-vnpay" id="btnPayVnpay">
                                <img src="{{ asset('images/vnpay-logo.svg') }}" alt="VNPay" class="vnpay-btn-logo" style="filter: brightness(0) invert(1);">
                                Thanh toán ngay
                            </button>
                        </form>
                        <a href="{{ route('client.memberships') }}" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i>
                            Quay lại chọn gói
                        </a>
                    </div>

                    <div class="vnpay-partner">
                        <span>Thanh toán bởi</span>
                        <img src="{{ asset('images/vnpay-logo.svg') }}" alt="VNPay" style="height: 20px; opacity: 0.7;">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
