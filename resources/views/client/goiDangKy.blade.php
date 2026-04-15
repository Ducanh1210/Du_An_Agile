@extends('layouts.client')

@section('title', 'Gói đã đăng ký — EXTRA FIT+')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
                <span style="color: var(--color-primary-light)">Gói đã đăng ký</span>
            </div>
            <h1 class="page-hero-title">Gói Đã <span>Đăng Ký</span></h1>
            <p class="page-hero-desc">Quản lý các gói tập của bạn — gia hạn hoặc thanh toán dễ dàng.</p>
        </div>
    </div>
</section>

{{-- ============================================================
     SUBSCRIPTIONS CONTENT
     ============================================================ --}}
<section class="profile-section">
    <div class="container">

        {{-- Navigation Tabs --}}
        <nav class="profile-nav" id="profileNav">
            <a href="{{ route('client.profile') }}" class="profile-nav-link">
                <i class="fas fa-user"></i> Thông tin cá nhân
            </a>
            <a href="{{ route('client.subscriptions') }}" class="profile-nav-link active">
                <i class="fas fa-star"></i> Gói đã đăng ký
            </a>
            <a href="{{ route('client.calendar') }}" class="profile-nav-link">
                <i class="fas fa-calendar-alt"></i> Lịch cá nhân
            </a>
        </nav>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="alert-bar alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert-bar alert-error">
            <i class="fas fa-times-circle"></i> {{ session('error') }}
        </div>
        @endif

        @if($subscriptions->count() > 0)
        <div class="sub-grid">
            @foreach($subscriptions as $sub)
            @php
                $statusClass = 'status-' . $sub->status;
                $statusLabels = [
                    'active' => 'Đang hoạt động',
                    'frozen' => 'Đóng băng',
                    'expired' => 'Hết hạn',
                    'cancelled' => 'Đã hủy',
                    'pending_payment' => 'Chờ thanh toán',
                ];
                $statusLabel = $statusLabels[$sub->status] ?? $sub->status;
                $daysLeft = $sub->daysRemaining();
                $progress = $sub->progressPercent();
                $isDanger = $daysLeft <= 7 && $sub->status === 'active';
            @endphp
            <div class="sub-card {{ $statusClass }}" id="subCard{{ $sub->id }}">
                {{-- Header --}}
                <div class="sub-card-header">
                    <div>
                        <div class="sub-card-name">{{ $sub->membership->name ?? 'Gói tập' }}</div>
                        <div class="sub-card-category">
                            <i class="fas {{ ($sub->membership->category ?? '') === 'yoga' ? 'fa-spa' : 'fa-dumbbell' }}"></i>
                            {{ ucfirst($sub->membership->category ?? 'gym') }}
                        </div>
                    </div>
                    <span class="sub-status sub-status-{{ $sub->status }}">
                        <i class="fas {{ $sub->status === 'active' ? 'fa-check-circle' : ($sub->status === 'frozen' ? 'fa-snowflake' : ($sub->status === 'cancelled' ? 'fa-ban' : 'fa-clock')) }}"></i>
                        {{ $statusLabel }}
                    </span>
                </div>

                {{-- Price --}}
                <div class="sub-price">
                    {{ number_format($sub->final_price, 0, ',', '.') }}đ
                    <small>/ {{ $sub->membership->duration_days ?? '?' }} ngày</small>
                </div>

                {{-- Progress --}}
                @if(in_array($sub->status, ['active', 'frozen']))
                <div class="sub-progress-wrap">
                    <div class="sub-progress-header">
                        <span>Còn lại: <strong>{{ $daysLeft }} ngày</strong></span>
                        <span>{{ $sub->start_date->format('d/m') }} — {{ $sub->end_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="sub-progress-bar">
                        <div class="sub-progress-fill {{ $isDanger ? 'danger' : '' }}" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
                @endif

                {{-- Meta --}}
                <div class="sub-meta">
                    <div class="sub-meta-item">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Bắt đầu: <strong>{{ $sub->start_date->format('d/m/Y') }}</strong></span>
                    </div>
                    <div class="sub-meta-item">
                        <i class="fas fa-calendar-check"></i>
                        <span>Kết thúc: <strong>{{ $sub->end_date->format('d/m/Y') }}</strong></span>
                    </div>
                    @if($sub->membership->allow_pt)
                    <div class="sub-meta-item">
                        <i class="fas fa-user-tie"></i>
                        <span>PT còn lại: <strong>{{ $sub->pt_sessions_left }}</strong> buổi</span>
                    </div>
                    @endif
                    @if($sub->frozen_until && $sub->status === 'frozen')
                    <div class="sub-meta-item">
                        <i class="fas fa-snowflake"></i>
                        <span>Đóng băng đến: <strong>{{ \Carbon\Carbon::parse($sub->frozen_until)->format('d/m/Y') }}</strong></span>
                    </div>
                    @endif
                </div>

                {{-- Trainer --}}
                @if($sub->trainer && $sub->trainer->user)
                <div class="sub-trainer">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($sub->trainer->user->name) }}&background=FF6B35&color=fff&size=36"
                         alt="{{ $sub->trainer->user->name }}" class="sub-trainer-avatar">
                    <div>
                        <div class="sub-trainer-name">{{ $sub->trainer->user->name }}</div>
                        <div class="sub-trainer-role">Huấn luyện viên cá nhân (PT)</div>
                    </div>
                </div>
                @endif

                {{-- Actions --}}
                @if($sub->status === 'pending_payment')
                {{-- ===== PENDING PAYMENT: Thanh toán ngay + Hủy đăng ký ===== --}}
                <div class="sub-actions">
                    <a href="{{ route('payment.checkout', ['package' => $sub->membership_id]) }}" class="btn btn-primary" id="btnPay{{ $sub->id }}">
                        <i class="fas fa-credit-card"></i> Thanh toán ngay
                    </a>
                    <button class="btn btn-cancel-sub" onclick="openModal('cancelModal{{ $sub->id }}')" id="btnCancel{{ $sub->id }}">
                        <i class="fas fa-times"></i> Hủy đăng ký
                    </button>
                </div>
                @elseif($sub->status === 'expired')
                {{-- ===== EXPIRED: Cho phép gia hạn ===== --}}
                <div class="sub-actions">
                    <button class="btn btn-primary" onclick="openModal('renewModal{{ $sub->id }}')" id="btnRenew{{ $sub->id }}">
                        <i class="fas fa-sync-alt"></i> Gia hạn
                    </button>
                </div>
                @endif
            </div>

            {{-- ============ RENEW MODAL ============ --}}
            @if($sub->status === 'expired')
            <div class="modal-overlay" id="renewModal{{ $sub->id }}">
                <div class="modal-card">
                    <div class="modal-header">
                        <span class="modal-title">Xác nhận gia hạn</span>
                        <button class="modal-close" onclick="closeModal('renewModal{{ $sub->id }}')"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body" style="text-align:center">
                        <div class="confirm-icon icon-renew"><i class="fas fa-sync-alt"></i></div>
                        <div class="confirm-title">Gia hạn gói?</div>
                        <div class="confirm-desc">
                            Gói <strong>{{ $sub->membership->name ?? '' }}</strong> sẽ được gia hạn thêm
                            <strong>{{ $sub->membership->duration_days ?? 30 }} ngày</strong>.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-ghost" onclick="closeModal('renewModal{{ $sub->id }}')">Hủy bỏ</button>
                        <form action="{{ route('client.subscription.renew', $sub->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Xác nhận gia hạn</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            {{-- ============ CANCEL MODAL (chỉ cho pending_payment) ============ --}}
            @if($sub->status === 'pending_payment')
            <div class="modal-overlay" id="cancelModal{{ $sub->id }}">
                <div class="modal-card">
                    <div class="modal-header">
                        <span class="modal-title">Hủy đăng ký</span>
                        <button class="modal-close" onclick="closeModal('cancelModal{{ $sub->id }}')"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body" style="text-align:center">
                        <div class="confirm-icon icon-cancel"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="confirm-title">Hủy gói chờ thanh toán?</div>
                        <div class="confirm-desc">
                            Bạn chắc chắn muốn hủy gói <strong>{{ $sub->membership->name ?? '' }}</strong>?
                            Gói chưa được thanh toán sẽ bị xóa khỏi danh sách.
                        </div>
                        <form action="{{ route('client.subscription.cancel', $sub->id) }}" method="POST" id="cancelForm{{ $sub->id }}">
                            @csrf
                            <div class="form-group" style="text-align:left;margin-top:var(--space-2)">
                                <label class="form-label">Lý do hủy (không bắt buộc)</label>
                                <textarea name="cancel_reason" class="form-control" rows="2"
                                          placeholder="Cho chúng tôi biết lý do bạn muốn hủy..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-ghost" onclick="closeModal('cancelModal{{ $sub->id }}')">Không, giữ lại</button>
                        <button type="submit" form="cancelForm{{ $sub->id }}" class="btn btn-danger">
                            <i class="fas fa-times"></i> Xác nhận hủy
                        </button>
                    </div>
                </div>
            </div>
            @endif

            @endforeach
        </div>
        @else
        {{-- Empty State --}}
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-box-open"></i></div>
            <h3 class="empty-title">Chưa có gói nào</h3>
            <p class="empty-desc">Bạn chưa đăng ký gói tập nào. Hãy khám phá các gói tập hấp dẫn của chúng tôi!</p>
            <a href="{{ url('/') }}#pricingSection" class="btn btn-primary btn-lg">
                <i class="fas fa-tags"></i> Xem gói tập
            </a>
        </div>
        @endif

    </div>
</section>

@endsection
