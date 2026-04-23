@extends('layouts.client')

@section('title', 'Lịch Lớp Học — EXTRA FIT+')

@section('styles')
<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#FF6B35',
                    'primary-dark': '#E85520',
                    'primary-light': '#FF8C5A',
                    dark: '#0f172a',
                    indigo: {
                        50: '#f5f3ff',
                        100: '#ede9fe',
                        200: '#ddd6fe',
                        500: '#6366f1',
                        600: '#4f46e5',
                    }
                },
                borderRadius: {
                    '4xl': '2rem',
                    '5xl': '3rem',
                }
            }
        }
    }
</script>
<!-- Alpine JS -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    :root {
        --header-h: 72px;
        --color-gym: #FF6B35;
        --color-yoga: #6366f1;
        --color-boxing: #ef4444;
    }

    .premium-schedule {
        background: #f8fafc;
        min-height: 100vh;
        padding-top: var(--header-h);
        font-family: 'Be Vietnam Pro', sans-serif;
    }

    /* --- Category Backgrounds --- */
    .bg-cl-bodybuilding, .bg-cl-gym { background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&q=80&auto=format&fit=crop'); }
    .bg-cl-yoga { background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)), url('https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800&q=80&auto=format&fit=crop'); }
    .bg-cl-boxing { background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)), url('https://images.unsplash.com/photo-1599058917223-952a220cf972?w=800&q=80&auto=format&fit=crop'); }

    /* --- Weekly Calendar Grid --- */
    .timetable-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1rem;
    }

    @media (max-width: 1024px) {
        .timetable-grid { grid-template-columns: 1fr; }
    }

    /* --- Sticky Sidebar --- */
    .sticky-sidebar {
        position: sticky;
        top: calc(var(--header-h) + 2rem);
        height: min-content;
    }

    /* --- Card Aesthetics --- */
    .class-card {
        background-size: cover;
        background-position: center;
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(255,255,255,0.05);
    }
    .class-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
    }

    /* Custom Scrollbar for side selection */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Transitions */
    .fade-enter { opacity: 0; transform: translateY(10px); }
    .fade-enter-active { opacity: 1; transform: translateY(0); transition: all 0.3s ease; }

    [x-cloak] { display: none !important; }
</style>
@endsection

@section('breadcrumb')
<div class="bg-slate-900 border-none py-4">
    <div class="container mx-auto px-6 flex items-center gap-3">
        <a href="{{ url('/') }}" class="text-slate-500 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest">Trang chủ</a>
        <i class="fas fa-chevron-right text-slate-700 text-[8px]"></i>
        <span class="text-white font-black text-xs uppercase tracking-[0.2em]">Lịch lớp học nhóm</span>
    </div>
</div>
@endsection

@section('content')
<div class="premium-schedule" x-data="{ 
    activeWeek: 0,
    activeDay: '{{ $dates[0]['full'] }}',
    activeCategory: 'all',
    loadingPT: false,
    selectedTrainer: '',
    selectedPTDate: '{{ date('Y-m-d') }}',
    selectedStartTime: '08:00'
}">
    
    <div class="container mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Left: Weekly Timetable (Full Width) -->
            <div class="lg:w-full">
                <div class="mb-10 flex flex-col md:flex-row justify-between items-end gap-6">
                    <div>
                        <h1 class="text-5xl font-black text-slate-900 uppercase tracking-tighter mb-2 italic">Lịch biểu <span class="text-primary italic">trong tuần</span></h1>
                        <p class="text-slate-500 font-bold uppercase text-[10px] tracking-[0.4em]">Khám phá các lớp học mới cùng chuyên gia</p>
                    </div>

                    <!-- Week Toggle -->
                    <div class="flex bg-white p-1.5 rounded-2xl shadow-sm border border-slate-100">
                        <button @click="activeWeek = 0; activeDay = '{{ $dates[0]['full'] }}'" :class="activeWeek === 0 ? 'bg-slate-900 text-white' : 'text-slate-500'" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Tuần này</button>
                        <button @click="activeWeek = 1; activeDay = '{{ $dates[7]['full'] }}'" :class="activeWeek === 1 ? 'bg-slate-900 text-white' : 'text-slate-500'" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Tuần tới</button>
                    </div>
                </div>

                <!-- Horizontal Date Selector (Apple Style) -->
                <div class="flex gap-4 mb-10 overflow-x-auto no-scrollbar pb-4">
                    @foreach($dates as $date)
                    <button 
                        x-show="({{ $date['index'] }} >= activeWeek * 7) && ({{ $date['index'] }} < (activeWeek + 1) * 7)"
                        @click="activeDay = '{{ $date['full'] }}'"
                        :class="activeDay === '{{ $date['full'] }}' ? 'bg-primary text-white scale-105 shadow-xl shadow-primary/30 border-transparent' : 'bg-white text-slate-400 border-slate-100'"
                        class="flex-shrink-0 w-24 h-28 rounded-3xl border flex flex-col items-center justify-center transition-all duration-300">
                        <span class="text-[9px] font-black uppercase tracking-widest mb-2 opacity-60">{{ $date['day_name'] }}</span>
                        <span class="text-3xl font-black mb-1 leading-none">{{ explode('/', $date['label'])[0] }}</span>
                        <span class="text-[9px] font-black uppercase tracking-[0.2em] opacity-60">Tháng {{ explode('/', $date['label'])[1] }}</span>
                    </button>
                    @endforeach
                </div>

                <!-- Category Switcher (Premium Tabs) -->
                <div class="flex flex-wrap items-center gap-3 mb-10">
                    <button @click="activeCategory = 'all'" 
                        :class="activeCategory === 'all' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-500 border-slate-100'"
                        class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest border transition-all flex items-center gap-2">
                        <i class="fas fa-th-large"></i> Tất cả
                    </button>
                    <button @click="activeCategory = 'gym'" 
                        :class="activeCategory === 'gym' ? 'bg-primary text-white shadow-lg shadow-primary/30 border-transparent' : 'bg-white text-slate-500 border-slate-100'"
                        class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest border transition-all flex items-center gap-2">
                        <i class="fas fa-dumbbell"></i> Gym & Fitness
                    </button>
                    <button @click="activeCategory = 'yoga'" 
                        :class="activeCategory === 'yoga' ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/30 border-transparent' : 'bg-white text-slate-500 border-slate-100'"
                        class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest border transition-all flex items-center gap-2">
                        <i class="fas fa-om"></i> Yoga & Thiền
                    </button>
                </div>

                <!-- Timetable Content -->
                <div class="space-y-6">
                    @foreach($dates as $date)
                    <template x-if="activeDay === '{{ $date['full'] }}'">
                        <div x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translateY-10" x-transition:enter-end="opacity-100 translateY-0" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @php 
                                $daySchedules = isset($schedules[$date['full']]) ? $schedules[$date['full']] : collect();
                            @endphp

                            @forelse($daySchedules as $item)
                                <div x-show="activeCategory === 'all' || activeCategory === '{{ $item->category }}'"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="class-card bg-cl-{{ $item->category }} p-8 text-white relative overflow-hidden group">
                                    <div class="relative z-10">
                                        <div class="flex justify-between items-start mb-8">
                                            <div class="flex flex-col">
                                                <span class="text-4xl font-black tracking-tighter italic mb-1">{{ $item->start_time->format('H:i') }}</span>
                                                <span class="text-[9px] font-black uppercase tracking-[0.3em] opacity-60">60 Phút</span>
                                            </div>
                                            <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest border border-white/10">
                                                {{ $item->category === 'gym' ? 'Gym & Fitness' : 'Yoga & Thiền' }}
                                            </span>
                                        </div>

                                        <h3 class="text-3xl font-black uppercase tracking-tighter mb-6 leading-none group-hover:text-primary transition-colors cursor-default">{{ $item->title }}</h3>

                                        <div class="flex items-center gap-4 mb-8">
                                            <img src="{{ $item->trainer->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($item->trainer->name) }}" class="w-10 h-10 rounded-xl object-cover ring-2 ring-white/20">
                                            <div>
                                                <div class="text-[8px] font-black uppercase tracking-widest opacity-50">HLV Chuyên nghiệp</div>
                                                <div class="text-sm font-bold">{{ $item->trainer->name }}</div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between gap-4">
                                            <div class="text-[10px] font-bold opacity-70 italic">
                                                <i class="fas fa-users mr-1"></i> {{ $item->current_enrolled }} / {{ $item->capacity }} chỗ trống
                                            </div>
                                            
                                            @auth
                                                @if($item->isFull())
                                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Đã đầy chỗ</span>
                                                @else
                                                    <form action="{{ route('bookings.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="schedule_id" value="{{ $item->id }}">
                                                        <button type="submit" class="px-6 py-3 bg-white text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-primary hover:text-white transition-all shadow-xl">Đăng ký ngay</button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="px-6 py-3 bg-primary text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-all shadow-xl">Đăng nhập để đặt</a>
                                            @endauth
                                        </div>
                                    </div>
                                    
                                    <!-- Decorative elements -->
                                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-primary/20 rounded-full blur-3xl group-hover:bg-primary/40 transition-all"></div>
                                </div>
                            @empty
                                <div class="col-span-1 md:col-span-2 py-32 bg-white rounded-[40px] border-2 border-dashed border-slate-100 flex flex-col items-center justify-center text-center">
                                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                                        <i class="fas fa-calendar-times text-4xl text-slate-200"></i>
                                    </div>
                                    <h3 class="text-2xl font-black text-slate-400 uppercase tracking-widest">Hôm nay không có lớp</h3>
                                    <p class="text-slate-300 text-xs font-bold uppercase mt-2 tracking-widest">Vui lòng chọn ngày khác hoặc đặt PT riêng</p>
                                </div>
                            @endforelse

                            <!-- Empty Category State -->
                            <div x-show="activeCategory !== 'all' && $el.closest('.grid').querySelectorAll('.class-card[style*=\'display: block\']').length === 0" 
                                 class="col-span-1 md:col-span-2 py-20 bg-white/50 rounded-[40px] border border-slate-100 flex flex-col items-center justify-center text-center">
                                <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Không có lớp <span x-text="activeCategory === 'gym' ? 'Gym & Fitness' : 'Yoga & Thiền'"></span> trong ngày này</p>
                            </div>
                        </div>
                    </template>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
