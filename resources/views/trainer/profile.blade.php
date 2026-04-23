@extends('layouts.trainer')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 40px;">
        <h1 style="font-size: 32px; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 8px;">Hồ sơ cá nhân</h1>
        <p style="color: var(--text-muted); font-weight: 500;">Quản lý thông tin công khai và cài đặt tài khoản của bạn.</p>
    </div>

    @if(session('success'))
        <div style="background: #ECFDF5; color: #10B981; padding: 16px 24px; border-radius: 16px; margin-bottom: 32px; font-weight: 700; display: flex; align-items: center; gap: 12px; border: 1px solid #D1FAE5;">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 32px; align-items: start;">
        <!-- Left Column: Avatar & Quick Info -->
        <div class="card" style="padding: 32px; text-align: center;">
            <div style="position: relative; width: 140px; height: 140px; margin: 0 auto 24px;">
                <img src="{{ $trainer->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($trainer->name).'&background=FF6B35&color=fff' }}" 
                     style="width: 100%; height: 100%; border-radius: 40px; object-fit: cover; border: 4px solid white; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                <button style="position: absolute; bottom: -5px; right: -5px; width: 40px; height: 40px; background: var(--primary); border: 4px solid white; border-radius: 14px; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                    <i class="fa-solid fa-camera" style="font-size: 16px;"></i>
                </button>
            </div>
            
            <h2 style="font-size: 20px; font-weight: 900; margin-bottom: 4px;">{{ $trainer->name }}</h2>
            <p style="color: var(--primary); font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 24px;">{{ $trainer->specialization ?? 'Huấn luyện viên' }}</p>
            
            <div style="background: #F8FAFC; border-radius: 20px; padding: 20px; text-align: left;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 12px; font-weight: 700; color: var(--text-muted);">ID HLV:</span>
                    <span style="font-size: 12px; font-weight: 800; color: var(--text-main);">#FT{{ str_pad($trainer->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 12px; font-weight: 700; color: var(--text-muted);">Gia nhập:</span>
                    <span style="font-size: 12px; font-weight: 800; color: var(--text-main);">{{ $trainer->created_at->format('M Y') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="font-size: 12px; font-weight: 700; color: var(--text-muted);">Trạng thái:</span>
                    <span style="font-size: 11px; font-weight: 800; color: #10B981; background: #ECFDF5; padding: 2px 8px; border-radius: 6px;">HOẠT ĐỘNG</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Edit Form -->
        <div class="card" style="padding: 40px;">
            <form action="{{ route('trainer.profile.update') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 800; margin-bottom: 10px;">Họ và tên</label>
                        <input type="text" name="name" value="{{ $trainer->name }}" style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 14px; font-size: 14px; font-weight: 700; outline: none; background: #F8FAFC;" required>
                    </div>
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 800; margin-bottom: 10px;">Email (Không thể đổi)</label>
                        <input type="email" value="{{ $trainer->email }}" disabled style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 14px; font-size: 14px; font-weight: 700; outline: none; background: #EEF2F6; color: var(--text-muted);">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 800; margin-bottom: 10px;">Số điện thoại</label>
                        <input type="text" name="phone" value="{{ $trainer->phone }}" style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 14px; font-size: 14px; font-weight: 700; outline: none; background: #F8FAFC;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 800; margin-bottom: 10px;">Chuyên môn chính</label>
                        <input type="text" name="specialization" value="{{ $trainer->specialization }}" placeholder="Ví dụ: Giảm cân, Tăng cơ, Yoga..." style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 14px; font-size: 14px; font-weight: 700; outline: none; background: #F8FAFC;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 800; margin-bottom: 10px;">Giá mỗi buổi PT (VNĐ)</label>
                        <input type="number" name="price_per_session" value="{{ $trainer->price_per_session }}" style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 14px; font-size: 14px; font-weight: 700; outline: none; background: #F8FAFC;">
                    </div>
                    <div style="display: flex; align-items: center; padding-top: 30px;">
                        <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                            <input type="checkbox" name="is_available" {{ $trainer->is_available ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: var(--primary);">
                            <span style="font-size: 14px; font-weight: 800;">Sẵn sàng nhận học viên mới</span>
                        </label>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; padding-top: 24px; border-top: 1px solid var(--border);">
                    <button type="submit" class="btn btn-primary" style="flex: 1; padding: 16px;">LƯU THAY ĐỔI</button>
                    <a href="{{ route('password.request') }}" class="btn btn-outline" style="flex: 1; padding: 16px; text-decoration: none; display: flex; align-items: center; justify-content: center;">ĐỔI MẬT KHẨU</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Section -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 32px;">
        <div class="card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Học viên</p>
                <h3 style="font-size: 20px; font-weight: 900;">24</h3>
            </div>
        </div>
        <div class="card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF1EB; color: #FF6B35; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <p style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Buổi dạy</p>
                <h3 style="font-size: 20px; font-weight: 900;">128</h3>
            </div>
        </div>
        <div class="card" style="padding: 24px; display: flex; align-items: center; gap: 20px;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: #ECFDF5; color: #10B981; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <p style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Đánh giá</p>
                <h3 style="font-size: 20px; font-weight: 900;">4.9/5</h3>
            </div>
        </div>
    </div>
</div>
@endsection
