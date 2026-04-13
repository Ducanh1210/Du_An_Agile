@extends('layouts.client')

@section('title', 'Lịch cá nhân — EXTRA FIT+')

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
                <span style="color: var(--color-primary-light)">Lịch cá nhân</span>
            </div>
            <h1 class="page-hero-title">Lịch <span>Cá Nhân</span></h1>
            <p class="page-hero-desc">Theo dõi lịch trình tập luyện và các buổi đã đặt của bạn.</p>
        </div>
    </div>
</section>

{{-- ============================================================
     CALENDAR CONTENT
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
            <a href="{{ route('client.calendar') }}" class="profile-nav-link active">
                <i class="fas fa-calendar-alt"></i> Lịch cá nhân
            </a>
        </nav>

        {{-- Filter Tabs --}}
        <div class="filter-tabs" id="calendarFilters">
            <button class="filter-tab active" data-filter="all" id="filterTabAll">Tất cả</button>
            <button class="filter-tab" data-filter="class" id="filterTabClass">
                <i class="fas fa-users"></i> Lớp học
            </button>
            <button class="filter-tab" data-filter="pt_session" id="filterTabPT">
                <i class="fas fa-user-tie"></i> PT
            </button>
        </div>

        <div class="calendar-wrapper">
            {{-- Calendar Grid --}}
            <div class="calendar-grid" id="calendarGrid">
                <div class="calendar-header">
                    <button class="calendar-nav-btn" id="calPrev" title="Tháng trước">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <h3 class="calendar-month-title" id="calMonthTitle">
                        {{ now()->translatedFormat('F Y') }}
                    </h3>
                    <button class="calendar-nav-btn" id="calNext" title="Tháng sau">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="calendar-days-grid" id="calDaysGrid">
                    {{-- Day names --}}
                    <div class="calendar-day-name">T2</div>
                    <div class="calendar-day-name">T3</div>
                    <div class="calendar-day-name">T4</div>
                    <div class="calendar-day-name">T5</div>
                    <div class="calendar-day-name">T6</div>
                    <div class="calendar-day-name">T7</div>
                    <div class="calendar-day-name">CN</div>

                    {{-- Calendar days populated via JS --}}
                </div>
            </div>

            {{-- Upcoming Sidebar --}}
            <div class="calendar-sidebar">
                <div class="upcoming-card">
                    <h3 class="upcoming-title"><i class="fas fa-bolt"></i> Sắp tới</h3>

                    @if($upcomingBookings->count() > 0)
                    <div class="upcoming-list">
                        @foreach($upcomingBookings as $booking)
                        <div class="upcoming-item" data-type="{{ $booking->booking_type }}" id="upcomingItem{{ $booking->id }}">
                            <div class="upcoming-date">
                                <span class="upcoming-date-day">{{ $booking->start_time->format('d') }}</span>
                                <span class="upcoming-date-month">Th{{ $booking->start_time->format('m') }}</span>
                            </div>
                            <div class="upcoming-info">
                                <div class="upcoming-info-title">
                                    @if($booking->schedule)
                                        {{ $booking->schedule->title }}
                                    @else
                                        Buổi tập PT
                                    @endif
                                </div>
                                <div class="upcoming-info-time">
                                    <i class="fas fa-clock"></i>
                                    {{ $booking->start_time->format('H:i') }} —
                                    {{ $booking->end_time->format('H:i') }}
                                </div>
                                <span class="upcoming-info-type {{ $booking->booking_type === 'class' ? 'type-class-badge' : 'type-pt-badge' }}">
                                    {{ $booking->booking_type === 'class' ? 'Lớp học' : 'PT' }}
                                </span>
                                @if($booking->trainer && $booking->trainer->user)
                                <div class="upcoming-info-time" style="margin-top:4px">
                                    <i class="fas fa-user-tie"></i> {{ $booking->trainer->user->name }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div style="text-align:center;padding:var(--space-3) 0;color:var(--color-text-muted)">
                        <i class="fas fa-calendar-times" style="font-size:32px;opacity:0.3;display:block;margin-bottom:8px"></i>
                        <p>Chưa có lịch tập sắp tới</p>
                    </div>
                    @endif
                </div>

                {{-- Stats mini card --}}
                <div class="upcoming-card">
                    <h3 class="upcoming-title"><i class="fas fa-chart-bar"></i> Thống kê tháng</h3>
                    @php
                        $thisMonthBookings = $bookings->where('start_time', '>=', now()->startOfMonth())
                                                      ->where('start_time', '<=', now()->endOfMonth());
                        $classCount = $thisMonthBookings->where('booking_type', 'class')->count();
                        $ptCount = $thisMonthBookings->where('booking_type', 'pt_session')->count();
                    @endphp
                    <div style="display:flex;gap:var(--space-2);margin-top:var(--space-1)">
                        <div style="flex:1;text-align:center;padding:12px;background:var(--color-bg);border-radius:var(--radius-btn)">
                            <div style="font-size:var(--font-size-xl);font-weight:800;color:var(--color-primary)">{{ $classCount }}</div>
                            <div style="font-size:12px;color:var(--color-text-muted)">Lớp học</div>
                        </div>
                        <div style="flex:1;text-align:center;padding:12px;background:var(--color-bg);border-radius:var(--radius-btn)">
                            <div style="font-size:var(--font-size-xl);font-weight:800;color:var(--color-info)">{{ $ptCount }}</div>
                            <div style="font-size:12px;color:var(--color-text-muted)">Buổi PT</div>
                        </div>
                        <div style="flex:1;text-align:center;padding:12px;background:var(--color-bg);border-radius:var(--radius-btn)">
                            <div style="font-size:var(--font-size-xl);font-weight:800;color:var(--color-success)">{{ $classCount + $ptCount }}</div>
                            <div style="font-size:12px;color:var(--color-text-muted)">Tổng</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    @php
        $formattedBookings = $bookings->map(function($b) {
            return [
                'id' => $b->id,
                'date' => $b->start_time->format('Y-m-d'),
                'type' => $b->booking_type,
                'title' => $b->schedule ? $b->schedule->title : 'Buổi tập PT',
                'time' => $b->start_time->format('H:i') . ' — ' . $b->end_time->format('H:i'),
            ];
        });
    @endphp

    // Booking data from server
    const bookingsData = @json($formattedBookings);

    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();

    const monthNames = [
        'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
        'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
    ];

    function renderCalendar(month, year) {
        const grid = document.getElementById('calDaysGrid');
        const title = document.getElementById('calMonthTitle');

        // Remove old day cells (keep day name headers)
        const dayNames = grid.querySelectorAll('.calendar-day-name');
        grid.querySelectorAll('.calendar-day').forEach(el => el.remove());

        title.textContent = monthNames[month] + ', ' + year;

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDay = (firstDay.getDay() + 6) % 7; // Monday = 0
        const totalDays = lastDay.getDate();

        // Previous month days
        const prevLastDay = new Date(year, month, 0).getDate();
        for (let i = startDay - 1; i >= 0; i--) {
            const cell = createDayCell(prevLastDay - i, true, null);
            grid.appendChild(cell);
        }

        // Current month days
        for (let d = 1; d <= totalDays; d++) {
            const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
            const dayBookings = bookingsData.filter(b => b.date === dateStr);
            const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
            const cell = createDayCell(d, false, dayBookings, isToday);
            grid.appendChild(cell);
        }

        // Next month days
        const totalCells = startDay + totalDays;
        const remaining = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
        for (let i = 1; i <= remaining; i++) {
            const cell = createDayCell(i, true, null);
            grid.appendChild(cell);
        }
    }

    function createDayCell(dayNum, isOther, bookings, isToday) {
        const cell = document.createElement('div');
        cell.className = 'calendar-day';
        if (isOther) cell.classList.add('other-month');
        if (isToday) cell.classList.add('today');

        const num = document.createElement('span');
        num.className = 'day-number';
        num.textContent = dayNum;
        cell.appendChild(num);

        if (bookings && bookings.length > 0) {
            const eventsWrap = document.createElement('div');
            eventsWrap.className = 'calendar-day-events';
            bookings.slice(0, 3).forEach(b => {
                const dot = document.createElement('span');
                dot.className = 'cal-event-dot type-' + b.type;
                dot.title = b.title + ' (' + b.time + ')';
                eventsWrap.appendChild(dot);
            });
            cell.appendChild(eventsWrap);
        }

        return cell;
    }

    // Navigation
    document.getElementById('calPrev')?.addEventListener('click', function() {
        currentMonth--;
        if (currentMonth < 0) { currentMonth = 11; currentYear--; }
        renderCalendar(currentMonth, currentYear);
    });

    document.getElementById('calNext')?.addEventListener('click', function() {
        currentMonth++;
        if (currentMonth > 11) { currentMonth = 0; currentYear++; }
        renderCalendar(currentMonth, currentYear);
    });

    // Filter tabs
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;

            document.querySelectorAll('.upcoming-item').forEach(item => {
                if (filter === 'all' || item.dataset.type === filter) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Initial render
    renderCalendar(currentMonth, currentYear);
});
</script>
@endsection
