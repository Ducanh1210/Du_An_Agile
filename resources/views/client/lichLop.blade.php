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
    .bg-cl-bodybuilding { background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&q=80&auto=format&fit=crop'); }
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
        <span class="text-white font-black text-xs uppercase tracking-[0.2em]">Lịch lớp & Đặt PT</span>
    </div>
</div>
@endsection

@section('content')
<div class="premium-schedule" x-data="{ 
    activeWeek: 0,
    activeDay: '{{ $dates[0]['full'] }}',
    loadingPT: false,
    selectedTrainer: '',
    selectedPTDate: '{{ date('Y-m-d') }}',
    selectedStartTime: '08:00'
}">
    
    <div class="container mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Left: Weekly Timetable (75%) -->
            <div class="lg:w-3/4">
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
                <div class="flex gap-4 mb-12 overflow-x-auto no-scrollbar pb-4">
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

                <!-- Timetable Content -->
                <div class="space-y-6">
                    @foreach($dates as $date)
                    <template x-if="activeDay === '{{ $date['full'] }}'">
                        <div x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translateY-10" x-transition:enter-end="opacity-100 translateY-0" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @php 
                                $daySchedules = isset($schedules[$date['full']]) ? $schedules[$date['full']] : collect();
                            @endphp

                            @forelse($daySchedules as $item)
                                <div class="class-card bg-cl-{{ $item->category }} p-8 text-white relative overflow-hidden group">
                                    <div class="relative z-10">
                                        <div class="flex justify-between items-start mb-8">
                                            <div class="flex flex-col">
                                                <span class="text-4xl font-black tracking-tighter italic mb-1">{{ $item->start_time->format('H:i') }}</span>
                                                <span class="text-[9px] font-black uppercase tracking-[0.3em] opacity-60">60 Minutes</span>
                                            </div>
                                            <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest border border-white/10">
                                                {{ $item->category }}
                                            </span>
                                        </div>

                                        <h3 class="text-3xl font-black uppercase tracking-tighter mb-6 leading-none group-hover:text-primary transition-colors cursor-default">{{ $item->title }}</h3>

                                        <div class="flex items-center gap-4 mb-8">
                                            <img src="{{ $item->trainer->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($item->trainer->user->name) }}" class="w-10 h-10 rounded-xl object-cover ring-2 ring-white/20">
                                            <div>
                                                <div class="text-[8px] font-black uppercase tracking-widest opacity-50">Master Trainer</div>
                                                <div class="text-sm font-bold">{{ $item->trainer->user->name }}</div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between gap-4">
                                            <div class="text-[10px] font-bold opacity-70 italic">
                                                <i class="fas fa-users mr-1"></i> {{ $item->current_enrolled }} / {{ $item->capacity }} slots
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
                        </div>
                    </template>
                    @endforeach
                </div>
            </div>

            <!-- Right: Quick PT Booking Sticky Sidebar (25%) -->
            <div class="lg:w-1/4">
                <div class="sticky-sidebar">
                    <div class="bg-white rounded-[40px] shadow-2xl shadow-slate-200/50 border border-slate-50 overflow-hidden relative">
                        <div class="p-10">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary text-2xl rotate-6">
                                    <i class="fas fa-user-ninja"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter mb-1">Đặt lịch PT</h3>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Huấn luyện viên cá nhân</p>
                                </div>
                            </div>

                            <div class="bg-slate-50 rounded-3xl p-6 mb-8 border border-slate-100">
                                <p class="text-xs font-bold text-slate-500 leading-relaxed italic">"Không tìm thấy khung giờ phù hợp? Hãy đặt lịch tập 1-kèm-1 để đạt hiệu quả tối ưu nhất."</p>
                            </div>

                            <form action="{{ route('pt-bookings.store') }}" method="POST" @submit="loadingPT = true" class="space-y-6">
                                @csrf
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Chọn Huấn luyện viên</label>
                                    <select name="trainer_id" required x-model="selectedTrainer" 
                                            class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all appearance-none cursor-pointer">
                                        <option value="">-- Danh sách HLV --</option>
                                        @foreach($trainers as $trainer)
                                            <option value="{{ $trainer->id }}">{{ $trainer->user->name }} ({{ $trainer->specialization }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Ngày tập dự kiến</label>
                                    <input type="date" name="date" required x-model="selectedPTDate" min="{{ date('Y-m-d') }}"
                                           class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all appearance-none cursor-pointer">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Khung giờ (1 Tiếng)</label>
                                    <input type="time" name="time_slot" required x-model="selectedStartTime"
                                           class="w-full bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20 transition-all appearance-none cursor-pointer">
                                </div>

                                <button type="submit" :disabled="loadingPT || !selectedTrainer"
                                        class="w-full py-5 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-primary transition-all shadow-xl shadow-slate-900/10 disabled:opacity-50 disabled:cursor-not-allowed group">
                                    <span x-show="!loadingPT">ĐẶT LỊCH NGAY <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i></span>
                                    <span x-show="loadingPT"><i class="fas fa-spinner fa-spin text-lg"></i></span>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Premium Footer -->
                        <div class="bg-slate-50/50 p-6 text-center border-t border-slate-50">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Extra Fit+ Fitness & Yoga Center</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
