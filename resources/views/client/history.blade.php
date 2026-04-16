@extends('layouts.client')

@section('title', 'Lịch sử thanh toán — EXTRA FIT+')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<style>
    .payment-table-container {
        background: var(--color-bg-card);
        border-radius: var(--radius-lg);
        padding: var(--space-4);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--color-border);
        overflow-x: auto;
    }
    
    .payment-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    
    .payment-table th {
        padding: var(--space-3) var(--space-4);
        border-bottom: 2px solid var(--color-border);
        color: var(--color-text-muted);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .payment-table td {
        padding: var(--space-4);
        border-bottom: 1px solid var(--color-border);
        vertical-align: middle;
    }
    
    .payment-package-name {
        font-weight: 600;
        color: var(--color-text-main);
    }
    
    .payment-amount {
        font-weight: 700;
        color: var(--color-primary);
    }
    
    .payment-method {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        color: var(--color-text-muted);
        font-size: 0.875rem;
    }
    
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: var(--space-1);
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-status-completed {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
    }
    
    .badge-status-pending {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }
    
    .badge-status-cancelled {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }
    
    .badge-status-refunded {
        background: rgba(107, 114, 128, 0.1);
        color: #4b5563;
    }
    
    .payment-date {
        font-size: 0.875rem;
        color: var(--color-text-muted);
    }
    
    .invoice-code {
        font-family: monospace;
        font-size: 0.8125rem;
        color: var(--color-text-muted);
        background: var(--color-bg-sub);
        padding: 0.125rem 0.375rem;
        border-radius: var(--radius-sm);
    }

    /* Empty state overrides for profile section */
    .profile-section .empty-state {
        padding: var(--space-8) 0;
    }
</style>
@endsection

@section('content')

{{-- ============================================================
     PAGE HERO
     ============================================================ --}}
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-breadcrumb">
                <a href="{{ route('home') }}">Trang chủ</a>
                <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <a href="{{ route('client.profile') }}">Hồ sơ</a>
                <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <span style="color: var(--color-primary-light)">Lịch sử thanh toán</span>
            </div>
            <h1 class="page-hero-title">Lịch Sử <span>Thanh Toán</span></h1>
            <p class="page-hero-desc">Theo dõi các giao dịch và hóa đơn dịch vụ của bạn.</p>
        </div>
    </div>
</section>

{{-- ============================================================
     HISTORY CONTENT
     ============================================================ --}}
<section class="profile-section">
    <div class="container">

        {{-- Navigation Tabs --}}
        <nav class="profile-nav" id="profileNav">
            <a href="{{ route('client.profile') }}" class="profile-nav-link">
                <i class="fas fa-user"></i> Thông tin cá nhân
            </a>
            <a href="{{ route('client.subscriptions') }}" class="profile-nav-link">
                <i class="fas fa-star"></i> Gói đã đăng ký
            </a>
            <a href="{{ route('client.calendar') }}" class="profile-nav-link">
                <i class="fas fa-calendar-alt"></i> Lịch cá nhân
            </a>
            <a href="{{ route('client.payment_history') }}" class="profile-nav-link active">
                <i class="fas fa-receipt"></i> Lịch sử thanh toán
            </a>
        </nav>

        @if($payments->count() > 0)
        <div class="payment-table-container">
            <table class="payment-table">
                <thead>
                    <tr>
                        <th>Gói tập</th>
                        <th>Số tiền</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th>Ngày thanh toán</th>
                        <th>Mã hóa đơn</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    @php
                        $methodIcons = [
                            'cash' => 'fa-money-bill-wave',
                            'transfer' => 'fa-university',
                            'e_wallet' => 'fa-wallet',
                        ];
                        $methodLabels = [
                            'cash' => 'Tiền mặt',
                            'transfer' => 'Chuyển khoản',
                            'e_wallet' => 'Ví điện tử',
                        ];
                        
                        $statusLabels = [
                            'pending' => 'Chờ xử lý',
                            'completed' => 'Thành công',
                            'cancelled' => 'Đã hủy',
                            'refunded' => 'Hoàn tiền',
                        ];
                    @endphp
                    <tr>
                        <td>
                            <div class="payment-package-name">
                                {{ $payment->subscription->membership->name ?? 'Dịch vụ lẻ' }}
                            </div>
                        </td>
                        <td>
                            <div class="payment-amount">
                                {{ number_format($payment->amount, 0, ',', '.') }}đ
                            </div>
                        </td>
                        <td>
                            <div class="payment-method">
                                <i class="fas {{ $methodIcons[$payment->method] ?? 'fa-credit-card' }}"></i>
                                {{ $methodLabels[$payment->method] ?? $payment->method }}
                            </div>
                        </td>
                        <td>
                            <span class="badge-status badge-status-{{ $payment->status }}">
                                <i class="fas {{ $payment->status === 'completed' ? 'fa-check-circle' : ($payment->status === 'pending' ? 'fa-clock' : ($payment->status === 'cancelled' ? 'fa-times-circle' : 'fa-info-circle')) }}"></i>
                                {{ $statusLabels[$payment->status] ?? $payment->status }}
                            </span>
                        </td>
                        <td>
                            <div class="payment-date">
                                {{ $payment->created_at->format('d/m/Y H:i') }}
                            </div>
                        </td>
                        <td>
                            <span class="invoice-code">{{ $payment->invoice_code ?? 'N/A' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        {{-- Empty State --}}
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-receipt"></i></div>
            <h3 class="empty-title">Chưa có giao dịch</h3>
            <p class="empty-desc">Bạn chưa thực hiện giao dịch thanh toán nào trên hệ thống.</p>
            <a href="{{ route('client.memberships') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-cart"></i> Đăng ký gói tập ngay
            </a>
        </div>
        @endif

    </div>
</section>

@endsection
