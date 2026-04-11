@extends('layouts.client')

@section('title', 'Lịch Lớp Học — EXTRA FIT+')

@section('styles')
<style>
    /* Hero Section */
    .schedule-hero {
        position: relative;
        height: 240px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1600&q=80&auto=format&fit=crop') center/cover no-repeat;
        color: #fff;
        margin-bottom: 30px;
    }
    .schedule-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(26, 26, 46, 0.8), rgba(26, 26, 46, 0.4));
    }
    .hero-content-wrap {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    /* Filters Container */
    .filters-section {
        background: #fff;
        padding: 20px 0;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 1px;
    }

    /* Custom Select */
    .custom-select-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .filter-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #94a3b8;
        letter-spacing: 1px;
    }
    #timeframeFilter {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        padding: 10px 20px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 700;
        color: #334155;
        outline: none;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 160px;
    }
    #timeframeFilter:focus {
        border-color: #ff6b35;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(255,107,53,0.1);
    }

    /* Date Selector Carousel */
    .day-selector-container {
        background: #fff;
        padding: 30px 0;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 40px;
    }
    .carousel-view {
        position: relative;
        display: flex;
        align-items: center;
        max-width: 1000px;
        margin: 0 auto;
    }
    .carousel-window {
        overflow: hidden;
        flex: 1;
        margin: 0 15px;
    }
    .day-selector-strip {
        display: flex;
        gap: 12px;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .day-btn {
        flex: 0 0 calc((100% - (12px * 6)) / 7);
        padding: 12px 10px;
        border-radius: 18px;
        background: #fff;
        border: 1.5px solid #f1f5f9;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        min-width: 85px;
    }
    @media (max-width: 992px) {
        .day-btn { flex: 0 0 calc((100% - (12px * 3)) / 4); }
    }
    @media (max-width: 640px) {
        .day-btn { flex: 0 0 calc((100% - (12px * 2)) / 3); }
    }

    .day-btn .day-name { font-size: 9px; text-transform: uppercase; font-weight: 800; color: #94a3b8; display: block; margin-bottom: 4px; }
    .day-btn .day-label { font-size: 17px; font-weight: 900; color: #1e293b; }

    .day-btn.active {
        background: #ff6b35;
        border-color: #ff6b35;
        box-shadow: 0 12px 20px -5px rgba(255,107,53,0.3);
        transform: translateY(-4px);
    }
    .day-btn.active .day-name, .day-btn.active .day-label { color: #fff; }

    .nav-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #fff;
        border: 1.5px solid #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        z-index: 10;
        flex-shrink: 0;
    }
    .nav-btn:hover:not(:disabled) {
        border-color: #ff6b35;
        color: #ff6b35;
        transform: scale(1.1);
        box-shadow: 0 10px 15px -3px rgba(255,107,53,0.2);
    }
    .nav-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    /* Schedule Content */
    .schedule-panel { display: none; }
    .schedule-panel.active { display: block; animation: slideUp 0.5s ease-out; }
    @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

    /* Class Cards */
    .class-card {
        background: #fff;
        border-radius: 28px;
        padding: 26px;
        display: grid;
        grid-template-columns: 100px 1fr 180px 160px;
        align-items: center;
        gap: 30px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #f8fafc;
        margin-bottom: 20px;
    }
    .class-card:hover { transform: translateY(-5px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08); border-color: #ff6b35; }

    .class-time { text-align: center; border-right: 1px solid #f1f5f9; }
    .time-start { font-size: 24px; font-weight: 900; color: #1e293b; display: block; }
    .time-end { font-size: 13px; color: #94a3b8; font-weight: 700; }

    .class-info { display: flex; flex-direction: column; gap: 6px; }
    .class-category { font-size: 10px; font-weight: 900; text-transform: uppercase; color: #ff6b35; letter-spacing: 2px; }
    .class-title { font-size: 20px; font-weight: 900; color: #1e293b; letter-spacing: -0.5px; }
    .class-meta { display: flex; gap: 15px; font-size: 13px; color: #64748b; font-weight: 600; }

    .class-trainer { display: flex; align-items: center; gap: 14px; }
    .trainer-avatar { width: 50px; height: 50px; border-radius: 16px; object-fit: cover; border: 2px solid #f1f5f9; }
    .trainer-name-text { font-weight: 800; font-size: 15px; color: #334155; }

    .btn-booking {
        padding: 12px 24px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
</style>
@endsection

@section('content')
<section class="schedule-hero">
    <div class="hero-content-wrap container">
        <h1 style="font-size: 48px; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 8px;">Hệ Thống Đặt Lịch</h1>
        <p style="font-size: 16px; font-weight: 500; opacity: 0.8; max-width: 600px; margin: 0 auto;">Lên kế hoạch tập luyện chuyên nghiệp cùng đội ngũ chuyên gia hàng đầu tại EXTRA FIT+.</p>
    </div>
</section>

<div class="filters-section">
    <div class="container flex flex-wrap items-center justify-between gap-6">
        <div class="custom-select-wrap">
            <span class="filter-label">Thời gian</span>
            <select id="timeframeFilter">
                <option value="7">7 ngày tới</option>
                <option value="14">14 ngày tới</option>
                <option value="30">30 ngày tới</option>
            </select>
        </div>

        @auth
        @php $sub = Auth::user()->activeSubscription(); @endphp
        @if($sub)
        <div class="flex items-center gap-6 bg-slate-50 px-6 py-3 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex flex-col">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Gói tập hiện tại</span>
                <span class="text-sm font-black text-slate-800">{{ $sub->membership->name }}</span>
            </div>
            <div class="w-px h-8 bg-slate-200"></div>
            <div class="flex flex-col">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Suất PT</span>
                <span class="text-sm font-black text-orange-600">{{ $sub->pt_sessions_left }} buổi</span>
            </div>
        </div>
        @endif
        @endauth
    </div>
</div>

<div class="day-selector-container">
    <div class="container">
        <div class="carousel-view">
            <button class="nav-btn" id="prevBtn" disabled>
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="carousel-window">
                <div class="day-selector-strip" id="dateStrip">
                    @foreach($dates as $index => $date)
                    <button class="day-btn {{ $date['is_today'] ? 'active' : '' }}" 
                            data-date="{{ $date['full'] }}" 
                            data-index="{{ $index }}"
                            style="{{ $index >= 7 ? 'display: none;' : '' }}">
                        <span class="day-name">{{ $date['day_name'] }}</span>
                        <span class="day-label">{{ $date['label'] }}</span>
                    </button>
                    @endforeach
                </div>
            </div>
            <button class="nav-btn" id="nextBtn">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<div class="container pb-24">
    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-3xl font-bold text-sm text-center animate-bounce">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-8 p-5 bg-red-50 border border-red-100 text-red-700 rounded-3xl font-bold text-sm text-center">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    @foreach($dates as $date)
    <div class="schedule-panel {{ $date['is_today'] ? 'active' : '' }}" id="panel-{{ $date['full'] }}">
        <div class="schedule-grid">
            @if(isset($schedules[$date['full']]))
                @foreach($schedules[$date['full']] as $item)
                <div class="class-card group">
                    <div class="class-time">
                        <span class="time-start">{{ $item->start_time->format('H:i') }}</span>
                        <span class="time-end">{{ $item->end_time->format('H:i') }}</span>
                    </div>
                    <div class="class-info">
                        <span class="class-category">{{ $item->category }}</span>
                        <h3 class="class-title">{{ $item->title }}</h3>
                        <div class="class-meta">
                            <span><i class="fas fa-users mr-1.5 opacity-40"></i> {{ $item->current_enrolled }}/{{ $item->capacity }} học viên</span>
                            <span><i class="fas fa-map-marker-alt mr-1.5 opacity-40"></i> {{ $item->room ?? 'Studio A' }}</span>
                        </div>
                    </div>
                    <div class="class-trainer">
                        <img src="{{ $item->trainer->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($item->trainer->user->name).'&background=FF6B35&color=fff' }}" class="trainer-avatar">
                        <span class="trainer-name-text">{{ $item->trainer->user->name }}</span>
                    </div>
                    <div class="class-status-wrap">
                        @if($item->current_enrolled >= $item->capacity)
                            <span class="px-5 py-2.5 bg-red-50 text-red-500 rounded-xl text-xs font-black uppercase tracking-widest border border-red-100">Hết chỗ</span>
                        @else
                            <form action="{{ route('bookings.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="schedule_id" value="{{ $item->id }}">
                                <button type="submit" class="btn-booking bg-slate-900 text-white hover:bg-orange-600 hover:scale-105 active:scale-95 shadow-xl shadow-slate-900/10">
                                    Đăng ký
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <div class="py-24 text-center bg-slate-50/50 rounded-[50px] border-2 border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <i class="far fa-calendar-times text-slate-200 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-300 uppercase tracking-widest mb-2">Chưa có lịch tập</h3>
                    <p class="text-slate-400 text-sm font-medium">Lớp học và slot tập cho ngày này đang được cập nhật.</p>
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
        const filter = document.getElementById('timeframeFilter');
        const dayBtns = document.querySelectorAll('.day-btn');
        const panels = document.querySelectorAll('.schedule-panel');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        
        let currentIndex = 0;
        let visibleCount = 7;
        let maxDays = 7;

        // Logic để cập nhật hiển thị nút
        function updateCarousel() {
            dayBtns.forEach((btn, idx) => {
                if (idx >= currentIndex && idx < currentIndex + visibleCount && idx < maxDays) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });

            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex + visibleCount >= maxDays;
        }

        // Thay đổi bộ lọc số ngày
        filter.addEventListener('change', (e) => {
            maxDays = parseInt(e.target.value);
            currentIndex = 0;
            
            // Nếu ngày đang chọn nằm ngoài phạm vi mới, nhảy về ngày đầu tiên
            const activeBtn = document.querySelector('.day-btn.active');
            if (activeBtn && parseInt(activeBtn.dataset.index) >= maxDays) {
                dayBtns[0].click();
            }
            
            updateCarousel();
        });

        // Nút Next/Prev
        nextBtn.addEventListener('click', () => {
            if (currentIndex + visibleCount < maxDays) {
                currentIndex += visibleCount;
                if (currentIndex + visibleCount > maxDays) {
                    currentIndex = maxDays - visibleCount;
                }
                updateCarousel();
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex -= visibleCount;
                if (currentIndex < 0) currentIndex = 0;
                updateCarousel();
            }
        });

        // Click chọn ngày
        dayBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const date = btn.getAttribute('data-date');
                dayBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                panels.forEach(p => p.classList.remove('active'));
                document.getElementById('panel-' + date).classList.add('active');
            });
        });

        // Khởi tạo ban đầu
        updateCarousel();
    });
</script>
@endsection
