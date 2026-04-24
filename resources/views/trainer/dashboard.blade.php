@extends('layouts.trainer')

@section('content')
<div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;">
    <div>
        <h1 style="font-size: 32px; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 4px;">Chào buổi sáng, {{ explode(' ', auth()->user()->name)[count(explode(' ', auth()->user()->name)) - 1] }}! 👋</h1>
        <p style="color: var(--text-muted); font-weight: 500;">Hôm nay là ngày {{ now()->locale('vi')->isoFormat('dddd, [ngày] D [tháng] M [năm] YYYY') }}</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <div class="card" style="margin-bottom: 0; padding: 12px 20px; display: flex; align-items: center; gap: 12px; border-radius: 14px;">
            <div style="width: 10px; height: 10px; background: #10B981; border-radius: 50%; box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);"></div>
            <span style="font-size: 13px; font-weight: 700; color: #10B981;">Đang hoạt động</span>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 40px;">
    <div class="card" style="margin-bottom: 0; border-left: 5px solid var(--primary);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div style="width: 48px; height: 48px; background: var(--primary-light); color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <span style="font-size: 12px; font-weight: 800; color: #10B981; background: #ECFDF5; padding: 4px 10px; border-radius: 20px;">Hôm nay</span>
        </div>
        <h3 style="font-size: 32px; font-weight: 900; margin-bottom: 4px;">{{ $stats['today_count'] }}</h3>
        <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Buổi tập cần hoàn thành</p>
    </div>

    <div class="card" style="margin-bottom: 0; border-left: 5px solid var(--secondary);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div style="width: 48px; height: 48px; background: #EFF6FF; color: var(--secondary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
        <h3 style="font-size: 32px; font-weight: 900; margin-bottom: 4px;">{{ $stats['student_count'] ?? 0 }}</h3>
        <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Học viên đang quản lý</p>
    </div>

    <div class="card" style="margin-bottom: 0; border-left: 5px solid #F59E0B;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div style="width: 48px; height: 48px; background: #FFFBEB; color: #F59E0B; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>
        <h3 style="font-size: 32px; font-weight: 900; margin-bottom: 4px;">{{ $stats['pending_reschedules'] }}</h3>
        <p style="color: var(--text-muted); font-size: 14px; font-weight: 600;">Yêu cầu đổi lịch chờ duyệt</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
    <!-- Today's Schedule -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 22px; font-weight: 800; letter-spacing: -0.5px;">Lịch trình hôm nay</h2>
            <a href="{{ route('trainer.schedule') }}" class="btn btn-outline" style="padding: 8px 16px;">Xem lịch tuần</a>
        </div>

        @if($todayBookings->isEmpty())
            <div class="card" style="text-align: center; padding: 80px 40px; background: rgba(255,255,255,0.5); border-style: dashed; border-width: 2px;">
                <img src="https://illustrations.popsy.co/gray/coffee-break.svg" style="width: 160px; margin-bottom: 24px;">
                <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 8px;">Không có ca dạy nào hôm nay!</h3>
                <p style="color: var(--text-muted); font-size: 14px; font-weight: 500;">Hãy tận dụng thời gian này để nghiên cứu giáo án<br>hoặc rèn luyện thêm kỹ năng cá nhân nhé.</p>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @foreach($todayBookings as $booking)
                <div class="card" style="margin-bottom: 0; padding: 24px; transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 24px; align-items: center;">
                        <!-- Time Column -->
                        <div style="text-align: center; padding-right: 24px; border-right: 1px solid var(--border);">
                            <div style="font-size: 20px; font-weight: 900; color: var(--text-main);">{{ $booking->start_time->format('H:i') }}</div>
                            <div style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">{{ $booking->start_time->format('A') }}</div>
                        </div>

                        <!-- User Info -->
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <img src="{{ $booking->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($booking->user->name).'&background=FF6B35&color=fff' }}" 
                                 style="width: 56px; height: 56px; border-radius: 16px; object-fit: cover;">
                            <div>
                                <h4 style="font-size: 17px; font-weight: 800; color: var(--text-main); margin-bottom: 4px;">{{ $booking->user->name }}</h4>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 13px; font-weight: 600; color: var(--primary);">{{ $booking->target_area }}</span>
                                    <span style="width: 4px; height: 4px; background: #CBD5E1; border-radius: 50%;"></span>
                                    <span style="font-size: 13px; color: var(--text-muted); font-weight: 500;">PT 1-kèm-1</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div style="display: flex; gap: 12px; align-items: center;">
                            @if($booking->status == 'completed')
                                <div style="background: #ECFDF5; color: #10B981; padding: 8px 16px; border-radius: 12px; font-weight: 700; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-check-circle"></i> Đã hoàn thành
                                </div>
                            @else
                                <form action="{{ route('trainer.booking.checkin', $booking->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Check-in</button>
                                </form>
                                <button onclick="openReportModal({{ $booking->id }})" class="btn btn-outline" style="padding: 10px 14px;"><i class="fa-solid fa-file-signature"></i></button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Quick Insights -->
    <aside>
        <div style="margin-bottom: 24px;">
            <h2 style="font-size: 22px; font-weight: 800; letter-spacing: -0.5px;">Phân tích nhanh</h2>
        </div>
        
        <div class="card" style="background: #0F172A; color: white; border: none;">
            <h4 style="font-size: 15px; font-weight: 700; color: #94A3B8; margin-bottom: 20px;">HIỆU SUẤT TUẦN NÀY</h4>
            <div style="display: flex; justify-content: space-between; align-items: flex-end; height: 120px; gap: 8px;">
                @foreach([40, 70, 45, 90, 65, 85, 30] as $h)
                    <div style="flex: 1; background: rgba(255,255,255,0.1); border-radius: 4px; position: relative;">
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: var(--primary); height: {{ $h }}%; border-radius: 4px; transition: height 1s;"></div>
                    </div>
                @endforeach
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 12px; font-size: 10px; font-weight: 700; color: #64748B;">
                <span>T2</span><span>T3</span><span>T4</span><span>T5</span><span>T6</span><span>T7</span><span>CN</span>
            </div>
        </div>

        <div class="card">
            <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 16px;">Ghi chú hôm nay</h4>
            <textarea placeholder="Ghi chú nhanh..." style="width: 100%; height: 100px; border: 1.5px solid var(--border); border-radius: 12px; padding: 12px; font-family: inherit; font-size: 13px; resize: none; outline: none; margin-bottom: 12px; background: #F8FAFC;"></textarea>
            <button class="btn btn-primary" style="width: 100%; font-size: 13px;">Lưu ghi chú</button>
        </div>
    </aside>
</div>

<!-- Report Modal (Modern Desktop) -->
<div id="reportModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(8px); z-index: 2000; padding: 40px; align-items: center; justify-content: center;">
    <div class="card" style="width: 100%; max-width: 550px; margin-bottom: 0; animation: modalEnter 0.3s ease-out;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 22px; font-weight: 900; letter-spacing: -0.5px;">Báo cáo buổi tập</h2>
            <button onclick="closeReportModal()" style="background: none; border: none; font-size: 20px; color: var(--text-muted); cursor: pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form id="reportForm" method="POST">
            @csrf
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 10px;">Nội dung buổi tập & Nhận xét</label>
                <textarea name="notes" rows="4" style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 16px; outline: none; font-family: inherit; font-size: 14px; transition: all 0.2s; background: #F8FAFC;" placeholder="Ví dụ: Học viên đã hoàn thành tốt các bài tập Squat, Lunges..."></textarea>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 10px;">Đánh giá nỗ lực (1-10)</label>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="range" name="effort_rating" min="1" max="10" value="7" oninput="document.getElementById('effortVal').innerText = this.value" style="flex: 1; accent-color: var(--primary);">
                        <span id="effortVal" style="font-size: 18px; font-weight: 900; color: var(--primary); min-width: 24px; text-align: center;">7</span>
                    </div>
                </div>
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 700; margin-bottom: 10px;">Cường độ</label>
                    <select name="session_intensity" style="width: 100%; border: 1.5px solid var(--border); border-radius: 12px; padding: 10px; font-family: inherit; font-weight: 600; outline: none; background: #F8FAFC;">
                        <option value="Low">Thấp</option>
                        <option value="Medium" selected>Vừa phải</option>
                        <option value="High">Cao</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeReportModal()" class="btn btn-outline">Hủy bỏ</button>
                <button type="submit" class="btn btn-primary" style="min-width: 200px;">Hoàn thành báo cáo</button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes modalEnter {
        from { opacity: 0; transform: translateY(20px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>

<script>
    function openReportModal(bookingId) {
        const modal = document.getElementById('reportModal');
        const form = document.getElementById('reportForm');
        form.action = `/trainer/bookings/${bookingId}/report`;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeReportModal() {
        document.getElementById('reportModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>
@endsection
