@extends('layouts.trainer')

@section('content')
<div class="welcome-section" style="margin-bottom: 24px;">
    <h1 style="font-size: 24px; font-weight: 800;">Chào buổi sáng, {{ auth()->user()->name }}! 👋</h1>
    <p style="color: var(--text-muted); font-size: 15px;">Hôm nay bạn có {{ $stats['today_count'] }} buổi tập cần hoàn thành.</p>
</div>

<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px;">
    <div class="card" style="margin-bottom: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px;">
        <span style="font-size: 28px; font-weight: 800; color: var(--primary);">{{ $stats['today_count'] }}</span>
        <span style="font-size: 13px; color: var(--text-muted);">Buổi tập hôm nay</span>
    </div>
    <div class="card" style="margin-bottom: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px;">
        <span style="font-size: 28px; font-weight: 800; color: var(--secondary);">{{ $stats['pending_reschedules'] }}</span>
        <span style="font-size: 13px; color: var(--text-muted);">Yêu cầu đổi lịch</span>
    </div>
</div>

<!-- Today's Mission -->
<div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <h2 style="font-size: 18px; font-weight: 700;">Nhiệm vụ hôm nay</h2>
    <span class="badge badge-primary">{{ now()->format('d/m/Y') }}</span>
</div>

@if($todayBookings->isEmpty())
    <div class="card" style="text-align: center; padding: 40px 20px;">
        <i class="fa-solid fa-mug-hot" style="font-size: 40px; color: var(--border); margin-bottom: 16px;"></i>
        <p style="color: var(--text-muted);">Hôm nay bạn không có lịch tập nào. Nghỉ ngơi thôi!</p>
    </div>
@else
    @foreach($todayBookings as $booking)
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
            <div style="display: flex; gap: 12px; align-items: center;">
                <img src="{{ $booking->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($booking->user->name).'&background=E2E8F0&color=64748B' }}" 
                     style="width: 48px; height: 48px; border-radius: 12px; object-fit: cover;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700;">{{ $booking->user->name }}</h3>
                    <p style="font-size: 13px; color: var(--text-muted);">
                        <i class="fa-regular fa-clock" style="margin-right: 4px;"></i>
                        {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}
                    </p>
                </div>
            </div>
            @if($booking->status == 'completed')
                <span class="badge badge-success">Đã hoàn thành</span>
            @else
                <span class="badge badge-blue">Sắp tới</span>
            @endif
        </div>
        
        @if($booking->status != 'completed')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 16px;">
            <form action="{{ route('trainer.booking.checkin', $booking->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" style="padding: 10px;">
                    <i class="fa-solid fa-check"></i> Check-in
                </button>
            </form>
            <a href="{{ route('trainer.student.detail', $booking->user_id) }}" class="btn btn-outline" style="padding: 10px; text-decoration: none;">
                <i class="fa-solid fa-chart-line"></i> Chỉ số
            </a>
        </div>
        <button onclick="openReportModal({{ $booking->id }})" class="btn" style="margin-top: 10px; background: #F1F5F9; color: var(--text-main); font-size: 13px;">
            <i class="fa-solid fa-pen-to-square"></i> Viết báo cáo & Ghi chú
        </button>
        @else
        <div style="margin-top: 12px; padding-top: 12px; border-top: 1px dashed var(--border);">
             <p style="font-size: 13px; color: #10B981; font-weight: 500;">
                 <i class="fa-solid fa-circle-check"></i> Buổi tập đã hoàn thành xuất sắc!
             </p>
        </div>
        @endif
    </div>
    @endforeach
@endif

<!-- Report Modal (Simple Overlay) -->
<div id="reportModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2000; padding: 20px; align-items: center; justify-content: center;">
    <div class="card" style="width: 100%; max-width: 500px; margin-bottom: 0;">
        <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Báo cáo buổi tập</h2>
        <form id="reportForm" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Nhận xét / Bài tập đã thực hiện</label>
                <textarea name="notes" rows="4" style="width: 100%; border: 1px solid var(--border); border-radius: 12px; padding: 12px; outline: none; transition: border-color 0.2s;" placeholder="Nhập ghi chú cho học viên..." required></textarea>
            </div>
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Đánh giá nỗ lực (1-10)</label>
                <input type="range" name="effort_rating" min="1" max="10" value="7" style="width: 100%; accent-color: var(--primary);">
                <div style="display: flex; justify-content: space-between; font-size: 12px; color: var(--text-muted);">
                    <span>Nhẹ (1)</span>
                    <span>Vắt kiệt (10)</span>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Cường độ</label>
                <select name="session_intensity" style="width: 100%; border: 1px solid var(--border); border-radius: 12px; padding: 12px;">
                    <option value="Low">Thấp (Phục hồi)</option>
                    <option value="Medium">Trung bình (Duy trì)</option>
                    <option value="High">Cao (Đốt mỡ / Tăng cơ)</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <button type="button" onclick="closeReportModal()" class="btn" style="background: #E2E8F0; color: var(--text-main);">Hủy</button>
                <button type="submit" class="btn btn-primary">Gửi báo cáo</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openReportModal(bookingId) {
        const modal = document.getElementById('reportModal');
        const form = document.getElementById('reportForm');
        form.action = `/trainer/bookings/${bookingId}/report`;
        modal.style.display = 'flex';
    }

    function closeReportModal() {
        document.getElementById('reportModal').style.display = 'none';
    }
</script>
@endsection
