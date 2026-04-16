@extends('layouts.client')

@section('title', 'Hồ sơ cá nhân — EXTRA FIT+')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

{{-- ============================================================
     PROFILE HERO
     ============================================================ --}}
<section class="profile-hero">
    <div class="container">
        <div class="profile-hero-content">
            <div class="profile-avatar-wrap">
                <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=FF6B35&color=fff&size=120' }}"
                     alt="{{ $user->name }}" class="profile-avatar-lg" id="profileAvatarPreview">
                <label class="profile-avatar-badge" title="Đổi ảnh đại diện" for="avatarInput">
                    <i class="fas fa-camera"></i>
                </label>
            </div>
            <div class="profile-hero-info">
                <h1 class="profile-hero-name">{{ $user->name }}</h1>
                <p class="profile-hero-email"><i class="fas fa-envelope" style="margin-right:6px;opacity:0.5"></i>{{ $user->email }}</p>
                <div class="profile-hero-stats">
                    <div class="profile-stat">
                        <div class="profile-stat-num">{{ $activeSubscriptions }}</div>
                        <div class="profile-stat-label">Gói đang dùng</div>
                    </div>
                    <div class="profile-stat">
                        <div class="profile-stat-num">{{ $totalBookings }}</div>
                        <div class="profile-stat-label">Buổi tập</div>
                    </div>
                    <div class="profile-stat">
                        <div class="profile-stat-num">{{ $user->created_at->diffInDays(now()) }}</div>
                        <div class="profile-stat-label">Ngày tham gia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     PROFILE CONTENT
     ============================================================ --}}
<section class="profile-section">
    <div class="container">

        {{-- Navigation Tabs --}}
        <nav class="profile-nav" id="profileNav">
            <a href="{{ route('client.profile') }}" class="profile-nav-link active">
                <i class="fas fa-user"></i> Thông tin cá nhân
            </a>
            <a href="{{ route('client.subscriptions') }}" class="profile-nav-link">
                <i class="fas fa-star"></i> Gói đã đăng ký
            </a>
            <a href="{{ route('client.calendar') }}" class="profile-nav-link">
                <i class="fas fa-calendar-alt"></i> Lịch cá nhân
            </a>
            <a href="{{ route('client.payment_history') }}" class="profile-nav-link">
                <i class="fas fa-receipt"></i> Lịch sử thanh toán
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

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: var(--space-3);">
            {{-- Personal Info Form --}}
            <div class="profile-card">
                <h2 class="profile-card-title"><i class="fas fa-user-edit"></i> Thông tin cá nhân</h2>
                <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="profile-form-grid">
                        <div class="form-group">
                            <label class="form-label">Họ và tên <span class="required">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-error @enderror"
                                   value="{{ old('name', $user->name) }}" required id="inputName">
                            @error('name')<span class="form-error" style="display:block">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled id="inputEmail">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}" placeholder="0909 xxx xxx" id="inputPhone">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ảnh đại diện</label>
                            <label class="avatar-upload-label" for="avatarInput">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span id="avatarFileName">Chọn ảnh...</span>
                                <input type="file" name="avatar" accept="image/*" id="avatarInput">
                            </label>
                        </div>
                    </div>

                    <div style="margin-top: var(--space-3)">
                        <button type="submit" class="btn btn-primary btn-lg" id="btnSaveProfile">
                            <i class="fas fa-save"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>

            {{-- Change Password Form --}}
            <div class="profile-card">
                <h2 class="profile-card-title"><i class="fas fa-lock"></i> Đổi mật khẩu</h2>
                <form action="{{ route('client.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Mật khẩu hiện tại <span class="required">*</span></label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-error @enderror"
                               placeholder="••••••••" required id="inputCurrentPassword">
                        @error('current_password')<span class="form-error" style="display:block">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mật khẩu mới <span class="required">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-error @enderror"
                               placeholder="••••••••" required id="inputNewPassword">
                        @error('password')<span class="form-error" style="display:block">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Xác nhận mật khẩu mới <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="••••••••" required id="inputConfirmPassword">
                    </div>

                    <div style="margin-top: var(--space-3)">
                        <button type="submit" class="btn btn-primary btn-lg" id="btnChangePassword">
                            <i class="fas fa-key"></i> Đổi mật khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('profileAvatarPreview');
    const avatarFileName = document.getElementById('avatarFileName');

    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                avatarFileName.textContent = file.name;
                const reader = new FileReader();
                reader.onload = function(ev) {
                    avatarPreview.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection
