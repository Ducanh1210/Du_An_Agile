@extends('layouts.trainer')

@section('styles')
<style>
    .day-group { margin-bottom: 40px; }
    .day-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }
    .day-date {
        font-size: 20px;
        font-weight: 900;
        letter-spacing: -0.5px;
        color: var(--text-main);
    }
    .day-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary);
        background: var(--primary-light);
        padding: 4px 12px;
        border-radius: 8px;
        text-transform: uppercase;
    }
    .day-line {
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .sessions-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .session-card {
        display: grid;
        grid-template-columns: 100px 1fr auto;
        align-items: center;
        gap: 24px;
        padding: 24px;
        background: var(--card-bg);
        border-radius: 20px;
        border: 1px solid var(--border);
        transition: all 0.2s;
    }
    .session-card:hover {
        transform: translateX(8px);
        border-color: var(--primary);
        box-shadow: var(--shadow);
    }

    .session-time {
        text-align: center;
        padding-right: 24px;
        border-right: 2px solid var(--bg);
    }
    .time-val { font-size: 22px; font-weight: 900; color: var(--text-main); line-height: 1; }
    .time-suffix { font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-top: 4px; }

    .session-main { display: flex; align-items: center; gap: 20px; }
    .student-img { width: 56px; height: 56px; border-radius: 16px; object-fit: cover; }
    .session-title { font-size: 18px; font-weight: 800; color: var(--text-main); margin-bottom: 4px; }
    .session-meta { display: flex; align-items: center; gap: 12px; font-size: 13px; color: var(--text-muted); font-weight: 600; }

    .badge {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .badge-pt { background: #FFF1EB; color: var(--primary); }
    .badge-class { background: #EFF6FF; color: var(--secondary); }
    .badge-pending { background: #FEF3C7; color: #D97706; }
    .badge-cancelled { background: #F1F5F9; color: #64748B; }

    .btn-leave {
        background: #FEF2F2;
        color: #EF4444;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-leave:hover { background: #EF4444; color: white; transform: translateY(-2px); }

    /* Modal Redesign */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(8px);
        z-index: 2000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }
    .modal-card {
        width: 100%;
        max-width: 500px;
        background: white;
        border-radius: 24px;
        padding: 32px;
        animation: modalFadeUp 0.3s ease-out;
    }
    @keyframes modalFadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 40px;">
    <h1 style="font-size: 32px; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 8px;">Lịch trình giảng dạy</h1>
    <p style="color: var(--text-muted); font-weight: 500;">Quản lý và theo dõi tất cả các buổi tập của bạn.</p>
</div>

@php
    $grouped = $allSchedules->groupBy(function($item) {
        return \Carbon\Carbon::parse($item->start_time)->format('Y-m-d');
    });
    $leaveLookup = [];
    foreach ($leaveRequests as $lr) {
        $leaveLookup[$lr->item_type . '-' . $lr->item_id] = $lr->status;
    }
@endphp

@if($grouped->isEmpty())
    <div class="card" style="text-align: center; padding: 100px 40px; border-style: dashed; border-width: 2px;">
        <img src="https://illustrations.popsy.co/gray/calendar.svg" style="width: 200px; margin-bottom: 24px;">
        <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 8px;">Không có ca dạy nào sắp tới</h3>
        <p style="color: var(--text-muted); font-weight: 500;">Khi có lịch mới, chúng sẽ xuất hiện tại đây.</p>
    </div>
@else
    @foreach($grouped as $date => $sessions)
        @php
            $carbon = \Carbon\Carbon::parse($date);
            $isToday = $carbon->isToday();
        @endphp
        <div class="day-group">
            <div class="day-header">
                <span class="day-date">{{ $carbon->format('d') }} Th{{ $carbon->format('m') }}, {{ $carbon->format('Y') }}</span>
                <span class="day-name">{{ $isToday ? 'Hôm nay' : $carbon->locale('vi')->isoFormat('dddd') }}</span>
                <div class="day-line"></div>
            </div>

            <div class="sessions-list">
                @foreach($sessions as $session)
                    @php
                        $isPT = $session->is_pt ?? false;
                        $itemType = $isPT ? 'App\Models\Booking' : 'App\Models\Schedule';
                        $leaveKey = $itemType . '-' . $session->id;
                        $leaveStatus = $leaveLookup[$leaveKey] ?? null;
                        $isCancelled = $session->status === 'cancelled';
                        
                        $title = $isPT ? ($session->user->name ?? 'Học viên') : ($session->class_name ?? 'Lớp Nhóm');
                        $avatar = $isPT ? ($session->user->avatar_url ?? null) : null;
                    @endphp

                    <div class="session-card {{ $isCancelled ? 'status-cancelled' : '' }}">
                        <div class="session-time">
                            <div class="time-val">{{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}</div>
                            <div class="time-suffix">{{ \Carbon\Carbon::parse($session->start_time)->format('A') }}</div>
                        </div>

                        <div class="session-main">
                            <img src="{{ $avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($title).'&background='.($isPT ? 'FF6B35' : '2563EB').'&color=fff' }}" class="student-img">
                            <div>
                                <h3 class="session-title">{{ $title }}</h3>
                                <div class="session-meta">
                                    <span class="badge {{ $isPT ? 'badge-pt' : 'badge-class' }}">
                                        <i class="fa-solid {{ $isPT ? 'fa-person-running' : 'fa-users' }}"></i>
                                        {{ $isPT ? 'PT 1-kèm-1' : 'Lớp nhóm' }}
                                    </span>
                                    @if($leaveStatus == 'pending')
                                        <span class="badge badge-pending">Đang chờ duyệt nghỉ</span>
                                    @elseif($isCancelled)
                                        <span class="badge badge-cancelled">Đã hủy</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="session-actions">
                            @if($isPT && !$isCancelled && !$leaveStatus)
                                <button class="btn-leave" onclick="openLeaveModal('{{ $session->id }}', '{{ addslashes($title) }}', '{{ \Carbon\Carbon::parse($session->start_time)->format('H:i d/m') }}')">
                                    <i class="fa-solid fa-hand"></i> Xin nghỉ
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endif

<!-- Leave Modal -->
<div class="modal-overlay" id="leaveModal">
    <div class="modal-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 22px; font-weight: 900; letter-spacing: -0.5px;">Đơn xin nghỉ dạy</h2>
            <button onclick="closeLeaveModal()" style="background:none; border:none; font-size:20px; color:var(--text-muted); cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <p id="modalSubText" style="background: #F8FAFC; padding: 12px 16px; border-radius: 12px; font-size: 14px; font-weight: 700; color: var(--text-main); margin-bottom: 24px;"></p>

        <form method="POST" action="{{ route('trainer.leave.submit') }}">
            @csrf
            <input type="hidden" name="item_id" id="leaveItemId">
            <input type="hidden" name="item_type" value="App\Models\Booking">

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 800; margin-bottom: 10px;">Lý do xin nghỉ <span style="color:#ef4444;">*</span></label>
                <textarea name="reason" rows="4" style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 16px; outline: none; font-family: inherit; font-size: 14px; background: #F8FAFC;" required placeholder="Ghi rõ lý do khẩn cấp..."></textarea>
            </div>

            <div style="background: #FEF2F2; padding: 16px; border-radius: 14px; display: flex; gap: 12px; margin-bottom: 24px;">
                <i class="fa-solid fa-circle-exclamation" style="color: #EF4444; margin-top: 3px;"></i>
                <p style="font-size: 12px; color: #B91C1C; font-weight: 600; line-height: 1.5;">Lưu ý: Việc xin nghỉ sẽ cần Admin duyệt. Sau khi duyệt, ca tập sẽ bị hủy và học viên sẽ nhận được thông báo.</p>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="closeLeaveModal()" class="btn btn-outline" style="flex: 1;">Hủy bỏ</button>
                <button type="submit" class="btn btn-primary" style="flex: 2; background: #EF4444;">Gửi đơn xin nghỉ</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openLeaveModal(itemId, title, timeStr) {
        document.getElementById('leaveItemId').value = itemId;
        document.getElementById('modalSubText').textContent = 'Ca dạy: ' + title + ' (' + timeStr + ')';
        document.getElementById('leaveModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeLeaveModal() {
        document.getElementById('leaveModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>
@endsection
