@extends('layouts.trainer')

@section('styles')
<style>
    .page-header {
        margin-bottom: 20px;
    }
    .page-header h1 {
        font-size: 22px;
        font-weight: 800;
        color: var(--text-main);
    }
    .page-header p {
        color: var(--text-muted);
        font-size: 14px;
        margin-top: 4px;
    }

    /* Day Group */
    .day-group { margin-bottom: 28px; }
    .day-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .day-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }
    .day-label.today-label { color: var(--primary); }

    /* Session Card */
    .session-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 12px;
        border: 1px solid var(--border);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        display: flex;
        gap: 14px;
        align-items: flex-start;
        position: relative;
        overflow: hidden;
    }
    .session-card.has-leave {
        opacity: 0.7;
        border-style: dashed;
    }
    .session-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        border-radius: 4px 0 0 4px;
    }
    .session-card.type-pt::before { background: var(--primary); }
    .session-card.type-class::before { background: var(--secondary); }
    .session-card.status-cancelled::before { background: #94A3B8; }

    .session-time {
        min-width: 58px;
        text-align: center;
    }
    .session-time .time-val {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.1;
    }
    .session-time .time-suffix {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .session-info { flex: 1; min-width: 0; }
    .session-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-main);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .session-sub {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 3px;
    }
    .session-badges {
        display: flex;
        gap: 6px;
        margin-top: 8px;
        flex-wrap: wrap;
    }
    .session-badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }
    .badge-pt { background: #fff1eb; color: var(--primary); }
    .badge-class { background: #eff6ff; color: var(--secondary); }
    .badge-pending-leave { background: #fef3c7; color: #d97706; }
    .badge-cancelled { background: #f1f5f9; color: #94a3b8; }

    .session-action { align-self: center; }
    .btn-leave {
        background: transparent;
        border: 1.5px solid #ef4444;
        color: #ef4444;
        padding: 7px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .btn-leave:hover { background: #fee2e2; }
    .btn-leave:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        border-color: #94a3b8;
        color: #94a3b8;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-muted);
    }
    .empty-state i { font-size: 48px; opacity: 0.3; margin-bottom: 16px; }
    .empty-state p { font-size: 15px; line-height: 1.7; }

    /* Modal */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.55);
        z-index: 3000;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        opacity: 0; pointer-events: none;
        transition: opacity 0.25s;
    }
    .modal-overlay.open { opacity: 1; pointer-events: all; }
    .modal-sheet {
        background: var(--card-bg);
        border-radius: 24px 24px 0 0;
        padding: 20px 20px 32px;
        width: 100%;
        max-width: 600px;
        transform: translateY(100%);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .modal-overlay.open .modal-sheet { transform: translateY(0); }
    .modal-handle {
        width: 40px; height: 4px;
        background: var(--border);
        border-radius: 2px;
        margin: 0 auto 20px;
    }
    .modal-title {
        font-size: 18px; font-weight: 800;
        color: var(--text-main);
        margin-bottom: 6px;
    }
    .modal-sub {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 18px;
    }
    .form-label {
        font-size: 13px; font-weight: 700;
        color: var(--text-main);
        margin-bottom: 6px;
        display: block;
    }
    .form-textarea {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        padding: 12px;
        font-size: 14px;
        font-family: inherit;
        resize: none;
        outline: none;
        transition: border-color 0.2s;
        min-height: 100px;
        color: var(--text-main);
    }
    .form-textarea:focus { border-color: #ef4444; }
    .modal-warn {
        background: #fef2f2; border-radius: 10px;
        padding: 10px 14px;
        font-size: 12px; color: #b91c1c;
        margin-top: 12px; margin-bottom: 18px;
        display: flex; align-items: flex-start; gap: 8px;
    }
    .modal-warn i { margin-top: 1px; flex-shrink: 0; }
    .btn-submit-leave {
        width: 100%;
        background: #ef4444;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
        font-family: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-submit-leave:hover { background: #dc2626; }
    .btn-cancel-modal {
        width: 100%;
        background: transparent;
        color: var(--text-muted);
        border: none;
        padding: 12px;
        font-size: 14px;
        cursor: pointer;
        font-family: inherit;
        margin-top: 8px;
    }

    /* Alert */
    .alert-error {
        background: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 12px;
        padding: 12px 16px;
        color: #b91c1c;
        font-size: 14px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="fa-solid fa-calendar-days" style="color: var(--primary);"></i> Lịch Dạy Của Tôi</h1>
    <p>Tất cả các ca dạy sắp tới của bạn</p>
</div>

@if(session('error'))
    <div class="alert-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        {{ session('error') }}
    </div>
@endif

@php
    $grouped = $allSchedules->groupBy(function($item) {
        return \Carbon\Carbon::parse($item->start_time)->format('Y-m-d');
    });

    // Build a lookup: item_type + item_id => leave status
    $leaveLookup = [];
    foreach ($leaveRequests as $lr) {
        $leaveLookup[$lr->item_type . '-' . $lr->item_id] = $lr->status;
    }
@endphp

@if($grouped->isEmpty())
    <div class="empty-state">
        <i class="fa-regular fa-calendar-xmark"></i>
        <p>Không có ca dạy nào sắp tới.<br>Hãy nghỉ ngơi và nạp năng lượng!</p>
    </div>
@else
    @foreach($grouped as $date => $sessions)
        @php
            $carbon = \Carbon\Carbon::parse($date);
            $isToday = $carbon->isToday();
            $dayStr = $isToday ? 'Hôm nay' : ucfirst($carbon->locale('vi')->isoFormat('dddd'));
            $dateStr = $carbon->format('d/m/Y');
        @endphp

        <div class="day-group">
            <div class="day-label {{ $isToday ? 'today-label' : '' }}">
                {{ $dayStr }}, {{ $dateStr }}
            </div>

            @foreach($sessions as $session)
                @php
                    $isPT = $session->is_pt ?? false;
                    $itemType = $isPT ? 'App\Models\Booking' : 'App\Models\Schedule';
                    $leaveKey = $itemType . '-' . $session->id;
                    $leaveStatus = $leaveLookup[$leaveKey] ?? null;
                    $isCancelled = $session->status === 'cancelled';
                    $hasPendingLeave = $leaveStatus === 'pending';
                    $hasApprovedLeave = $leaveStatus === 'approved';

                    $title = $isPT
                        ? ($session->user->name ?? 'Học viên')
                        : ($session->class_name ?? 'Lớp Nhóm');
                    $sub = $isPT
                        ? 'PT Session 1-kèm-1'
                        : ($session->description ?? 'Lớp tập nhóm');
                    $duration = $isPT ? '60 phút' : ($session->duration ?? '60' . ' phút');
                @endphp

                <div class="session-card type-{{ $isPT ? 'pt' : 'class' }} {{ $isCancelled || $hasApprovedLeave ? 'status-cancelled' : '' }} {{ $hasPendingLeave ? 'has-leave' : '' }}">
                    <div class="session-time">
                        <div class="time-val">{{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}</div>
                        <div class="time-suffix">{{ \Carbon\Carbon::parse($session->start_time)->format('A') }}</div>
                    </div>
                    <div class="session-info">
                        <div class="session-title">{{ $title }}</div>
                        <div class="session-sub">{{ $sub }}</div>
                        <div class="session-badges">
                            <span class="session-badge {{ $isPT ? 'badge-pt' : 'badge-class' }}">
                                <i class="fa-solid {{ $isPT ? 'fa-person-running' : 'fa-users' }}" style="font-size:10px;"></i>
                                {{ $isPT ? 'PT Session' : 'Lớp nhóm' }}
                            </span>
                            @if($hasPendingLeave)
                                <span class="session-badge badge-pending-leave">
                                    <i class="fa-solid fa-clock" style="font-size:10px;"></i> Đang chờ duyệt nghỉ
                                </span>
                            @elseif($hasApprovedLeave || $isCancelled)
                                <span class="session-badge badge-cancelled">
                                    <i class="fa-solid fa-ban" style="font-size:10px;"></i> Đã hủy
                                </span>
                            @endif
                        </div>
                    </div>
                    @if($isPT && !$isCancelled && !$leaveStatus)
                        <div class="session-action">
                            <button class="btn-leave"
                                onclick="openLeaveModal('{{ $session->id }}', '{{ addslashes($title) }}', '{{ \Carbon\Carbon::parse($session->start_time)->format('H:i d/m') }}')"
                            >
                                <i class="fa-solid fa-hand"></i>
                                Xin nghỉ
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
@endif

{{-- Modal Xin nghỉ --}}
<div class="modal-overlay" id="leaveModal">
    <div class="modal-sheet">
        <div class="modal-handle"></div>
        <div class="modal-title"><i class="fa-solid fa-hand" style="color:#ef4444;"></i> Đơn Xin Nghỉ Dạy</div>
        <div class="modal-sub" id="modalSubText">Ca dạy: --</div>

        <form method="POST" action="{{ route('trainer.leave.submit') }}" id="leaveForm">
            @csrf
            <input type="hidden" name="item_id" id="leaveItemId">
            <input type="hidden" name="item_type" value="App\Models\Booking">

            <label class="form-label">Lý do xin nghỉ <span style="color:#ef4444;">*</span></label>
            <textarea
                name="reason"
                class="form-textarea"
                required
                minlength="5"
                placeholder="Vui lòng ghi rõ lý do xin nghỉ (ốm, việc cá nhân khẩn cấp, v.v.)&#10;&#10;Lưu ý: Không có lý do hợp lệ sẽ bị trừ lương!"
            ></textarea>

            <div class="modal-warn">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Sau khi được duyệt, ca dạy sẽ bị HỦY. Học viên sẽ nhận thông báo. Không có buổi học bù.</span>
            </div>

            <button type="submit" class="btn-submit-leave">
                <i class="fa-solid fa-paper-plane"></i>
                Nộp Đơn Xin Nghỉ
            </button>
            <button type="button" class="btn-cancel-modal" onclick="closeLeaveModal()">
                Hủy bỏ
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openLeaveModal(itemId, title, timeStr) {
    document.getElementById('leaveItemId').value = itemId;
    document.getElementById('modalSubText').textContent = 'Ca dạy: ' + title + ' — ' + timeStr;
    document.querySelector('#leaveForm textarea').value = '';
    document.getElementById('leaveModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLeaveModal() {
    document.getElementById('leaveModal').classList.remove('open');
    document.body.style.overflow = '';
}

// Close on backdrop click
document.getElementById('leaveModal').addEventListener('click', function(e) {
    if (e.target === this) closeLeaveModal();
});
</script>
@endsection
