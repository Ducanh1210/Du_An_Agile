@extends('layouts.client')

@section('title', 'Lịch Lớp Học — EXTRA FIT+')

@section('styles')
<style>
    /* Hero Section */
    .schedule-hero {
        position: relative;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=1600&q=80&auto=format&fit=crop') center/cover no-repeat;
        color: #fff;
        margin-bottom: var(--space-6);
    }
    .schedule-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(26, 26, 46, 0.7);
    }
    .hero-content-wrap {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    /* Day Selector Overlay */
    .day-selector-container {
        position: sticky;
        top: var(--header-height-desktop);
        z-index: 100;
        background: var(--color-surface);
        padding: var(--space-2) 0;
        box-shadow: var(--shadow-header);
        margin-bottom: var(--space-6);
        border-bottom: 1px solid var(--color-border);
    }
    .day-selector-scroll {
        display: flex;
        justify-content: center;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 5px;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .day-selector-scroll::-webkit-scrollbar { display: none; }

    .day-btn {
        flex: 0 0 auto;
        padding: 12px 20px;
        border-radius: 12px;
        background: var(--color-bg);
        border: 1.5px solid var(--color-border);
        text-align: center;
        transition: all var(--transition-base);
        min-width: 100px;
    }
    .day-btn .day-name { font-size: 12px; text-transform: uppercase; font-weight: 700; color: var(--color-text-muted); display: block; }
    .day-btn .day-label { font-size: 18px; font-weight: 800; color: var(--color-text); }

    .day-btn.active {
        background: var(--color-primary);
        border-color: var(--color-primary);
        box-shadow: var(--shadow-btn);
        transform: translateY(-2px);
    }
    .day-btn.active .day-name, .day-btn.active .day-label { color: #fff; }

    /* Schedule Content */
    .schedule-panel {
        display: none;
    }
    .schedule-panel.active {
        display: block;
        animation: fadeIn 0.4s ease;
    }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* Schedule List */
    .schedule-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: var(--space-3);
    }

    .class-card {
        background: var(--color-surface);
        border-radius: var(--radius-card);
        padding: var(--space-3);
        display: grid;
        grid-template-columns: 120px 1fr 180px 150px;
        align-items: center;
        gap: var(--space-4);
        box-shadow: var(--shadow-card);
        transition: all var(--transition-base);
        border-left: 5px solid var(--color-primary);
    }
    .class-card:hover { transform: scale(1.01); box-shadow: var(--shadow-card-hover); }

    .class-time {
        text-align: center;
        border-right: 1px solid var(--color-border);
    }
    .time-start { font-size: 24px; font-weight: 800; color: var(--color-text); display: block; }
    .time-end { font-size: 14px; color: var(--color-text-muted); font-weight: 600; }

    .class-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .class-category { font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--color-primary-light); }
    .class-title { font-size: 20px; font-weight: 800; color: var(--color-text); }
    .class-meta { display: flex; gap: 15px; font-size: 13px; color: var(--color-text-muted); }

    .class-trainer {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .trainer-avatar {
        width: 44px; height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--color-primary);
    }
    .trainer-name-text { font-weight: 600; font-size: 15px; }

    .class-status-wrap {
        text-align: right;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 16px;
        border-radius: var(--radius-badge);
        font-size: 13px;
        font-weight: 700;
        display: inline-block;
    }
    .status-upcoming { background: rgba(34, 197, 94, 0.1); color: #22C55E; }
    .status-full { background: rgba(239, 68, 68, 0.1); color: #EF4444; }

    @media (max-width: 992px) {
        .class-card {
            grid-template-columns: 100px 1fr 1fr;
            grid-template-areas: "time info status" "time trainer trainer";
        }
        .class-time { grid-area: time; }
        .class-info { grid-area: info; }
        .class-trainer { grid-area: trainer; margin-top: 10px; }
        .class-status-wrap { grid-area: status; }
    }

    @media (max-width: 576px) {
        .class-card {
            grid-template-columns: 1fr;
            grid-template-areas: "time" "info" "trainer" "status";
            text-align: center;
        }
        .class-time { border-right: none; border-bottom: 1px solid var(--color-border); padding-bottom: 10px; }
        .class-status-wrap { text-align: center; }
        .class-trainer { justify-content: center; }
        .day-btn { min-width: 80px; padding: 10px; }
    }
</style>
@endsection

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="display: flex; gap: 8px; font-size: 14px; padding: 16px 0;">
        <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: var(--color-primary);">Trang chủ</a></li>
        <li class="breadcrumb-item active" style="color: var(--color-text-muted);" aria-current="page"> / Lịch lớp học</li>
    </ol>
</nav>
@endsection

@section('content')
<section class="schedule-hero">
    <div class="hero-content-wrap container animate-on-scroll">
        <h1 class="hero-title" style="font-size: 40px; font-weight: 900;">Lịch Lớp Học Hàng Tuần</h1>
        <p class="hero-subtitle">Tra cứu thời gian tập luyện và chọn lớp học phù hợp với lịch trình của bạn.</p>
    </div>
</section>

<div class="day-selector-container">
    <div class="container">
        <div class="day-selector-scroll" id="daySelector">
            @php
                $days = [
                    2 => 'Thứ 2',
                    3 => 'Thứ 3',
                    4 => 'Thứ 4',
                    5 => 'Thứ 5',
                    6 => 'Thứ 6',
                    7 => 'Thứ 7',
                    8 => 'Chủ Nhật'
                ];
                $today = \Carbon\Carbon::now()->dayOfWeek + 1;
                if ($today == 1) $today = 8; // Fix for Sunday
            @endphp
            @foreach($days as $num => $name)
            <button class="day-btn {{ $num == $today ? 'active' : '' }}" data-day="{{ $num }}">
                <span class="day-name">Daily</span>
                <span class="day-label">{{ $name }}</span>
            </button>
            @endforeach
        </div>
    </div>
</div>

<div class="container pb-10">
    @foreach($days as $num => $name)
    <div class="schedule-panel {{ $num == $today ? 'active' : '' }}" id="panel-{{ $num }}">
        <div class="schedule-grid">
            @if(isset($schedules[$num]))
                @foreach($schedules[$num] as $item)
                <div class="class-card animate-on-scroll" style="border-left-color: {{ $item->category == 'yoga' ? '#22C55E' : '#FF6B35' }}">
                    <div class="class-time">
                        <span class="time-start">{{ $item->start_time->format('H:i') }}</span>
                        <span class="time-end">{{ $item->end_time->format('H:i') }}</span>
                    </div>
                    <div class="class-info">
                        <span class="class-category" style="color: {{ $item->category == 'yoga' ? '#22C55E' : '#FF6B35' }}">
                            {{ strtoupper($item->category) }}
                        </span>
                        <h3 class="class-title">{{ $item->title }}</h3>
                        <div class="class-meta">
                            <span><i class="fas fa-users"></i> {{ $item->current_enrolled }}/{{ $item->capacity }} chỗ</span>
                            <span><i class="fas fa-clock"></i> {{ $item->start_time->diffInMinutes($item->end_time) }} phút</span>
                        </div>
                    </div>
                    <div class="class-trainer">
                        <img src="{{ $item->trainer->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($item->trainer->user->name).'&background=FF6B35&color=fff' }}" 
                             alt="HLV" class="trainer-avatar">
                        <div class="trainer-info-sub">
                            <span class="text-muted d-block" style="font-size: 11px;">Huấn luyện viên</span>
                            <span class="trainer-name-text">{{ $item->trainer->user->name }}</span>
                        </div>
                    </div>
                    <div class="class-status-wrap">
                        @if($item->current_enrolled >= $item->capacity)
                            <span class="status-badge status-full">Hết chỗ</span>
                        @else
                            <button class="btn btn-primary btn-sm">Đăng ký lớp</button>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-icon"><i class="far fa-calendar-times"></i></div>
                    <h3 class="empty-title">Không có lớp học nào trong ngày này</h3>
                    <p class="empty-desc">Vui lòng chọn ngày khác hoặc liên hệ hotline để được hỗ trợ.</p>
                </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dayBtns = document.querySelectorAll('.day-btn');
        const panels = document.querySelectorAll('.schedule-panel');

        dayBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const day = btn.getAttribute('data-day');
                
                // Active btn
                dayBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                // Active panel
                panels.forEach(p => p.classList.remove('active'));
                document.getElementById('panel-' + day).classList.add('active');

                // Smooth scroll to panel
                window.scrollTo({
                    top: document.querySelector('.day-selector-container').offsetTop - 80,
                    behavior: 'smooth'
                });
            });
        });
    });
</script>
@endsection
