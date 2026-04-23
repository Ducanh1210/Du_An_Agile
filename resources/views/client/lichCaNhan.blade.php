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
            <a href="{{ route('client.payment_history') }}" class="profile-nav-link">
                <i class="fas fa-receipt"></i> Lịch sử thanh toán
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
                    <h3 class="upcoming-title" id="sidebarTitle"><i class="fas fa-bolt"></i> Sắp tới</h3>

                    <div id="sidebarList">
                        @if($upcomingBookings->count() > 0)
                        <div class="upcoming-list">
                            @foreach($upcomingBookings as $booking)
                            <div class="upcoming-item" 
                                 data-type="{{ $booking->booking_type }}" 
                                 data-date="{{ $booking->start_time->format('Y-m-d') }}"
                                 id="upcomingItem{{ $booking->id }}">
                                <div class="upcoming-date">
                                    <span class="upcoming-date-day">{{ $booking->start_time->format('d') }}</span>
                                    <span class="upcoming-date-month">Th{{ $booking->start_time->format('m') }}</span>
                                </div>
                                <div class="upcoming-info">
                                    <div class="upcoming-info-title">
                                        @if($booking->booking_type === 'class')
                                            {{ $booking->schedule->title }}
                                        @else
                                            Tập {{ $booking->target_area ?? 'PT' }}
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
                                    @if($booking->trainer)
                                    <div class="upcoming-info-time" style="margin-top:4px">
                                        <i class="fas fa-user-tie"></i> {{ $booking->trainer->name }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div style="text-align:center;padding:var(--space-3) 0;color:var(--color-text-muted)">
                            <i class="fas fa-calendar-times" style="font-size:32px;opacity:0.3;display:block;margin-bottom:8px"></i>
                            <p>Không có lịch tập</p>
                        </div>
                        @endif
                    </div>
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
            $titleShort = $b->booking_type === 'class' ? $b->schedule?->title : ($b->target_area ? 'Tập ' . $b->target_area : 'PT');
            
            // Map area to color class
            $colorClass = 'label-fullbody';
            if ($b->booking_type === 'class') {
                $colorClass = 'label-class';
                if (stripos($b->schedule->title, 'Yoga') !== false) $colorClass = 'label-yoga';
                if (stripos($b->schedule->title, 'Zumba') !== false) $colorClass = 'label-zumba';
            } else {
                $area = mb_strtolower($b->target_area);
                if (str_contains($area, 'bụng')) $colorClass = 'label-abs';
                elseif (str_contains($area, 'chân')) $colorClass = 'label-legs';
                elseif (str_contains($area, 'tay')) $colorClass = 'label-arms';
                elseif (str_contains($area, 'ngực')) $colorClass = 'label-chest';
                elseif (str_contains($area, 'lưng')) $colorClass = 'label-back';
            }

            return [
                'id' => $b->id,
                'date' => $b->start_time->format('Y-m-d'),
                'type' => $b->booking_type,
                'is_virtual' => false,
                'title' => $b->booking_type === 'class' ? $b->schedule->title : 'Tập ' . ($b->target_area ?? 'PT'),
                'title_short' => $titleShort,
                'color_class' => $colorClass,
                'time' => $b->start_time->format('H:i') . ' — ' . $b->end_time->format('H:i'),
            ];
        });

        // Convert weekly plan to JS-friendly
        $jsWeeklyPlan = $weeklyPlan;

        $formattedGymSchedules = $gymSchedules->map(function($s) {
            return [
                'date' => $s->start_time->format('Y-m-d'),
                'title' => $s->title,
                'time' => $s->start_time->format('H:i'),
                'trainer' => $s->trainer ? $s->trainer->name : 'HLV Chuyên nghiệp',
                'category' => $s->category,
                'id' => $s->id
            ];
        });
    @endphp

    // Weekly Plan and Booking data
    const bookingsData = @json($formattedBookings);
    const weeklyPlan = @json($jsWeeklyPlan);
    const gymSchedules = @json($formattedGymSchedules);

    function getPersonalWorkout(dateStr) {
        const d = new Date(dateStr);
        let dayOfWeek = d.getDay(); // 0 is Sunday, 1 is Monday...
        if (dayOfWeek === 0) dayOfWeek = 7;
        return weeklyPlan[dayOfWeek];
    }

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
            let dayBookings = bookingsData.filter(b => b.date === dateStr);
            
            // If no actual bookings, inject virtual workout
            if (dayBookings.length === 0) {
                const plan = getPersonalWorkout(dateStr);
                if (plan && plan.area !== 'rest') {
                    dayBookings = [{
                        date: dateStr,
                        type: 'personal',
                        is_virtual: true,
                        title: 'Tự tập: ' + plan.title,
                        title_short: plan.title,
                        color_class: 'label-' + plan.area + ' virtual-label',
                        time: 'Tự do'
                    }];
                }
            }

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

        // Calculate date string for all cells
        const monthForCell = isOther ? (dayNum > 20 ? currentMonth - 1 : currentMonth + 1) : currentMonth;
        const yearForCell = currentYear;
        const dateObj = new Date(yearForCell, monthForCell, dayNum);
        const dateStr = dateObj.toISOString().split('T')[0];
        
        cell.dataset.date = dateStr;
        cell.style.cursor = 'pointer';

        if (bookings && bookings.length > 0) {
            const eventsWrap = document.createElement('div');
            eventsWrap.className = 'calendar-day-events';
            bookings.slice(0, 2).forEach(b => {
                const label = document.createElement('div');
                label.className = 'cal-event-label ' + b.color_class;
                if (b.is_virtual) label.classList.add('is-virtual');
                label.textContent = b.title_short;
                eventsWrap.appendChild(label);
            });
            cell.appendChild(eventsWrap);
        }

        cell.onclick = () => filterSidebarByDate(dateStr, cell, bookings || []);

        return cell;
    }

    function filterSidebarByDate(dateStr, cell, dayBookings) {
        // Update UI
        document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('active-day'));
        cell.classList.add('active-day');

        // Update Title
        const d = new Date(dateStr);
        const isPast = d.setHours(0,0,0,0) < new Date().setHours(0,0,0,0);
        
        document.getElementById('sidebarTitle').innerHTML = `<i class="fas fa-calendar-day"></i> Lịch ngày ${d.getDate()}/${d.getMonth()+1}`;

        // Clear and rebuild sidebar list
        const sidebarWrapper = document.getElementById('sidebarList');
        sidebarWrapper.innerHTML = '';
        
        const listDiv = document.createElement('div');
        listDiv.className = 'upcoming-list';
        sidebarWrapper.appendChild(listDiv);

        if (dayBookings && dayBookings.length > 0) {
            dayBookings.forEach(b => {
                const item = document.createElement('div');
                item.className = 'upcoming-item';
                if (b.is_virtual) item.classList.add('virtual-item');
                
                item.innerHTML = `
                    <div class="upcoming-date" style="${b.is_virtual ? 'background:#cbd5e1' : ''}">
                        <span class="upcoming-date-day">${d.getDate()}</span>
                        <span class="upcoming-date-month">Th${d.getMonth()+1}</span>
                    </div>
                    <div class="upcoming-info">
                        <div class="upcoming-info-title">${b.title}</div>
                        <div class="upcoming-info-time">
                            <i class="fas fa-clock"></i> ${b.time}
                        </div>
                        <span class="upcoming-info-type ${b.type === 'class' ? 'type-class-badge' : (b.type === 'pt_session' ? 'type-pt-badge' : 'type-personal-badge')}">
                            ${b.type === 'class' ? 'Lớp học' : (b.type === 'pt_session' ? 'PT' : 'Tự tập')}
                        </span>
                    </div>
                `;
                listDiv.appendChild(item);
            });

            // Check if we should also show booking buttons (if all bookings are virtual)
            const hasRealBooking = dayBookings.some(b => !b.is_virtual);
            if (!hasRealBooking && !isPast) {
                const prompt = document.createElement('div');
                prompt.style.cssText = 'margin-top: 20px; padding-top: 20px; border-top: 1px dashed var(--color-border);';
                prompt.innerHTML = `
                    <p style="color:var(--color-text-muted); font-size:12px; margin-bottom:15px; text-align:center;">Bạn muốn đổi sang tập cùng chuyên gia?</p>
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        <a href="{{ route('trainers') }}" class="btn btn-primary btn-md w-full" style="border-radius: 14px;">
                            <i class="fas fa-user-tie"></i> Đặt lịch PT ngay
                        </a>
                        <a href="{{ route('schedule') }}" class="btn btn-outline-primary btn-md w-full" style="border-radius: 14px; border-color: var(--color-info); color: var(--color-info);">
                            <i class="fas fa-users"></i> Đăng ký lớp học
                        </a>
                    </div>
                `;
                listDiv.appendChild(prompt);
            }
        } else {
            // No bookings - show booking prompt if date is future or today
            const emptyState = document.createElement('div');
            emptyState.style.cssText = 'text-align:center; padding: 32px 0;';
            emptyState.innerHTML = `
                <div style="margin-bottom: 20px; position: relative; display: inline-block;">
                    <i class="fas fa-calendar-plus" style="font-size:48px; opacity:0.1; color:var(--color-primary)"></i>
                    <i class="fas fa-plus" style="position: absolute; bottom: 0; right: -5px; font-size: 14px; color: var(--color-primary); background: var(--color-surface); border-radius: 50%; padding: 2px;"></i>
                </div>
                <p style="color:var(--color-text-muted); font-size:14px; font-weight: 600; margin-bottom: 24px;">Ngày này hiện đang trống lịch</p>
                ${!isPast ? `
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <a href="{{ route('trainers') }}" class="btn btn-primary btn-md w-full" style="border-radius: 14px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">
                            <i class="fas fa-user-tie"></i> Đặt lịch PT
                        </a>
                        <a href="{{ route('schedule') }}" class="btn btn-outline-primary btn-md w-full" style="border-radius: 14px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; border-color: var(--color-info); color: var(--color-info);">
                            <i class="fas fa-users"></i> Đăng ký lớp
                        </a>
                    </div>
                ` : '<p style="font-size: 11px; color: var(--color-text-muted); font-style: italic;">Không thể đặt lịch cho ngày đã qua</p>'}
            `;
            listDiv.appendChild(emptyState);
        }

        // --- NEW: SHOW GYM CLASS SUGGESTIONS ---
        const dayGymSchedules = gymSchedules.filter(s => s.date === dateStr);
        if (dayGymSchedules.length > 0 && !isPast) {
            const gymTitle = document.createElement('p');
            gymTitle.style.cssText = 'color:var(--color-primary); font-size:11px; font-weight:800; text-transform:uppercase; margin-top:24px; margin-bottom:12px; letter-spacing:1px; border-top: 1px solid var(--color-border); padding-top: 20px;';
            gymTitle.innerHTML = '<i class="fas fa-dumbbell mr-1"></i> Các lớp học tại CLB ngày này';
            listDiv.appendChild(gymTitle);

            dayGymSchedules.forEach(s => {
                const sItem = document.createElement('div');
                sItem.className = 'upcoming-item';
                sItem.style.background = 'var(--color-surface)';
                sItem.style.border = '1px solid var(--color-border)';
                sItem.innerHTML = `
                    <div class="upcoming-info">
                        <div class="upcoming-info-title" style="font-size:13px; color: var(--color-text);">${s.title}</div>
                        <div class="upcoming-info-time" style="font-size:11px;">
                            <i class="fas fa-clock"></i> ${s.time} • HLV: ${s.trainer}
                        </div>
                    </div>
                    <a href="{{ route('schedule') }}" class="btn btn-sm btn-primary" style="height:32px; font-size:10px; padding:0 12px; border-radius: 10px;">Đăng ký</a>
                `;
                listDiv.appendChild(sItem);
            });
        }
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
