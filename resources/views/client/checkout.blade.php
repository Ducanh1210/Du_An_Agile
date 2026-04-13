@extends('layouts.client')

@section('title', 'Xác nhận thanh toán — EXTRA FIT+')

@section('styles')
<style>
    .checkout-wrapper {
        padding: var(--space-8) 0;
        background: var(--color-background);
        min-height: calc(100vh - 80px);
    }
    .checkout-header {
        margin-bottom: var(--space-6);
        text-align: left;
    }
    .checkout-title {
        font-size: clamp(24px, 4vw, 36px);
        font-weight: 800;
        color: var(--color-text);
        text-transform: uppercase;
        letter-spacing: -0.5px;
    }
    .checkout-title span {
        color: var(--color-primary);
    }
    .checkout-subtitle {
        color: var(--color-text-muted);
        margin-top: 8px;
    }
    
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--space-6);
    }
    @media (min-width: 992px) {
        .checkout-grid {
            grid-template-columns: 2fr 1fr;
        }
    }

    /* Details Panel */
    .checkout-panel {
        background: var(--color-surface);
        border-radius: var(--radius-card);
        border: 1px solid var(--color-border);
        padding: var(--space-6);
        margin-bottom: var(--space-4);
        box-shadow: var(--shadow-sm);
    }
    .panel-title {
        font-size: var(--font-size-xl);
        font-weight: 700;
        color: var(--color-text);
        margin-bottom: var(--space-4);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .panel-title i {
        color: var(--color-primary);
    }
    
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
        border-bottom: 1px dashed var(--color-border);
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-label {
        color: var(--color-text-muted);
    }
    .info-value {
        font-weight: 600;
        color: var(--color-text);
        font-size: 16px;
    }
    .info-value.highlight {
        color: var(--color-primary);
        font-size: 20px;
        font-weight: 800;
    }

    /* Warning box */
    .warning-box {
        background: rgba(255, 107, 53, 0.1);
        border: 1px solid rgba(255, 107, 53, 0.2);
        border-radius: var(--radius-card);
        padding: var(--space-4);
        display: flex;
        gap: 16px;
    }
    .warning-icon {
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-primary);
        flex-shrink: 0;
    }
    .warning-content h4 {
        color: #b33900;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .warning-content p {
        color: #d14605;
        font-size: 14px;
    }

    /* Summary Side */
    .summary-card {
        background: var(--color-text);
        color: var(--color-surface);
        border-radius: var(--radius-card);
        padding: var(--space-6);
        position: sticky;
        top: 100px;
    }
    .summary-card .panel-title {
        color: #fff;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 16px;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        color: rgba(255,255,255,0.7);
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-top: 16px;
        margin-top: 16px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    .summary-total .label {
        font-weight: 700;
        color: #fff;
    }
    .summary-total .value {
        font-size: 28px;
        font-weight: 900;
        color: var(--color-primary);
    }

    .action-buttons {
        margin-top: var(--space-6);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .btn-vnpay {
        background: var(--color-primary);
        color: #fff;
        border: none;
        padding: 16px;
        border-radius: var(--radius-btn);
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
    }
    .btn-vnpay:hover {
        background: #cf4f1e;
        transform: translateY(-2px);
    }
    .btn-back {
        background: rgba(255,255,255,0.1);
        color: #fff;
        border: none;
        padding: 16px;
        border-radius: var(--radius-btn);
        font-weight: 700;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.2);
        color: #fff;
    }
    .vnpay-logo {
        margin-top: var(--space-5);
        text-align: center;
        opacity: 0.5;
        filter: grayscale(100%);
    }
    .vnpay-logo img {
        height: 24px;
    }
</style>
@endsection

@section('content')
<div class="checkout-wrapper">
    <div class="container" style="max-width: 1000px;">
        <div class="checkout-header">
            <h1 class="checkout-title">Xác nhận <span>Thanh toán</span></h1>
            <p class="checkout-subtitle">Vui lòng kiểm tra lại thông tin gói tập trước khi tiến hành thanh toán.</p>
        </div>

        <div class="checkout-grid">
            <!-- Order Details -->
            <div class="checkout-main">
                <div class="checkout-panel">
                    <h3 class="panel-title">
                        <i class="fa-solid fa-receipt"></i>
                        Thông tin gói tập
                    </h3>
                    
                    <ul class="info-list">
                        <li class="info-item">
                            <span class="info-label">Tên gói:</span>
                            <span class="info-value highlight">{{ $membership->name }}</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Thời hạn:</span>
                            <span class="info-value">{{ $membership->duration_days }} ngày</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Buổi PT đi kèm:</span>
                            <span class="info-value">{{ $membership->pt_sessions ?? 0 }} buổi</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Người đăng ký:</span>
                            <span class="info-value">{{ auth()->user()->name }}</span>
                        </li>
                    </ul>
                </div>

                <div class="warning-box">
                    <div class="warning-icon">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div class="warning-content">
                        <h4>Lưu ý quan trọng</h4>
                        <p>Gói tập sẽ được kích hoạt ngay sau khi thanh toán thành công. Dịch vụ không hỗ trợ hoàn tiền sau khi đã kích hoạt gói.</p>
                    </div>
                </div>
            </div>

            <!-- Summary Table -->
            <div class="checkout-sidebar">
                <div class="summary-card">
                    <h3 class="panel-title">Tổng cộng</h3>
                    
                    <div class="summary-details">
                        <div class="summary-item">
                            <span>Giá gói:</span>
                            <span>{{ number_format($membership->price, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="summary-item">
                            <span>Phí dịch vụ:</span>
                            <span>0đ</span>
                        </div>
                        <div class="summary-total">
                            <span class="label">Thành tiền:</span>
                            <span class="value">{{ number_format($membership->price, 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <form action="{{ route('payment.vnpay') }}" method="POST">
                        @csrf
                        <input type="hidden" name="membership_id" value="{{ $membership->id }}">
                        
                        <div class="action-buttons">
                            <button type="submit" class="btn-vnpay">
                                <i class="fa-solid fa-credit-card"></i>
                                Thanh toán VNPay
                            </button>
                            <a href="{{ route('client.memberships') }}" class="btn-back">
                                Quay lại
                            </a>
                        </div>
                    </form>

                    <div class="vnpay-logo">
                        <img src="https://vnpay.vn/sweb/face/resources/images/logo-vnpay.png" alt="VNPay">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
