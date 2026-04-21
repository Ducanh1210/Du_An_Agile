@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Quản lý lịch học')

@section('content')
{{-- Header Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8 uppercase tracking-tighter">
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1">Tổng lịch học</div>
            <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $stats['countAll'] }}</div>
        </div>
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
    </div>
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1">Hôm nay</div>
            <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ $stats['countToday'] }}</div>
        </div>
        <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-clock"></i>
        </div>
    </div>
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1">Sắp diễn ra</div>
            <div class="text-2xl font-bold text-emerald-600 tracking-tight">{{ $stats['countUpcoming'] }}</div>
        </div>
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-flag-checkered"></i>
        </div>
    </div>
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1">Đã hủy</div>
            <div class="text-2xl font-bold text-red-500 tracking-tight">{{ $stats['countCancelled'] }}</div>
        </div>
        <div class="w-12 h-12 bg-red-100 text-red-400 rounded-2xl flex items-center justify-center text-xl group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-calendar-xmark"></i>
        </div>
    </div>
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1">Tháng này</div>
            <div class="text-2xl font-bold text-sky-600 tracking-tight">{{ $stats['countThisMonth'] }}</div>
        </div>
        <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center text-xl group-hover:bg-sky-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-calendar-week"></i>
        </div>
    </div>
</div>

{{-- Calendar Card --}}
<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    {{-- Toolbar --}}
    <div class="px-8 py-5 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight leading-normal">
                <i class="fa-solid fa-calendar-days text-orange-600 mr-2"></i>
                Lịch lớp học — Tháng {{ $currentMonth }}/{{ $currentYear }}
            </h2>
            <p class="text-sm text-slate-400 font-medium tracking-tighter uppercase whitespace-nowrap">Xem tổng quan lịch trình huấn luyện theo tháng.</p>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            {{-- Month Navigation --}}
            <div class="flex bg-slate-100 rounded-2xl p-1 gap-1">
                @foreach($monthsNav as $nav)
                    <a href="{{ route('admin.schedules.index', ['month' => $nav['month'], 'year' => $nav['year']]) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200
                              {{ $nav['active']
                                  ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/20'
                                  : 'text-slate-500 hover:bg-white hover:shadow-sm' }}">
                        {{ $nav['label'] }}
                    </a>
                @endforeach
            </div>
            <a href="{{ route('admin.schedules.create') }}" class="px-5 py-2.5 bg-orange-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-orange-600/20 hover:bg-orange-700 hover:scale-105 active:scale-95 transition-all whitespace-nowrap">
                <i class="fa-solid fa-plus mr-1.5"></i> Thêm lịch
            </a>
        </div>
    </div>

    {{-- Calendar Grid --}}
    <div class="p-4 md:p-6">
        {{-- Day headers --}}
        <div class="grid grid-cols-7 mb-2">
            @php
                $dayNames = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
            @endphp
            @foreach($dayNames as $dayName)
                <div class="text-center py-3 text-[10px] font-bold text-slate-400 uppercase tracking-[.2em]">{{ $dayName }}</div>
            @endforeach
        </div>

        {{-- Calendar cells --}}
        @php
            $today = now()->format('Y-m-d');
            $firstDayOfWeek = $startOfMonth->copy()->dayOfWeek; // 0=Sunday
            $daysInMonth = $startOfMonth->daysInMonth;
        @endphp

        <div class="grid grid-cols-7 border-l border-t border-gray-100 rounded-2xl overflow-hidden">
            {{-- Empty cells for days before the 1st of the month --}}
            @for($i = 0; $i < $firstDayOfWeek; $i++)
                <div class="bg-gray-50/50 border-r border-b border-gray-100 p-2">
                    <div class="h-7"></div>
                    <div class="flex flex-col gap-1">
                        <div class="h-[22px]"></div>
                        <div class="h-[22px]"></div>
                        <div class="h-[22px]"></div>
                        <div class="h-[18px]"></div>
                    </div>
                </div>
            @endfor

            {{-- Actual day cells --}}
            @for($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $dateKey = \Carbon\Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
                    $isToday = ($dateKey === $today);
                    $daySchedules = $schedulesByDate->get($dateKey, collect());
                    $hasSchedules = $daySchedules->isNotEmpty();
                    $shownSchedules = $daySchedules->take(3);
                    $shownCount = $shownSchedules->count();
                @endphp
                <div class="border-r border-b border-gray-100 p-1.5 md:p-2 transition-colors duration-150
                            {{ $isToday ? 'bg-orange-50/60 ring-2 ring-inset ring-orange-200' : ($hasSchedules ? 'bg-white hover:bg-slate-50/80' : 'bg-white') }}">
                    {{-- Day number --}}
                    <div class="flex items-center justify-between mb-1 h-7">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-bold
                                     {{ $isToday ? 'bg-orange-600 text-white shadow-sm shadow-orange-600/30' : 'text-slate-600' }}">
                            {{ $day }}
                        </span>
                        @if($hasSchedules)
                            <span class="text-[9px] font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded-md">{{ $daySchedules->count() }}</span>
                        @endif
                    </div>

                    {{-- Fixed 4-row schedule grid (no scrolling) --}}
                    <div class="flex flex-col gap-1">
                        {{-- Row 1-3: Schedule items or empty spacers --}}
                        @for($slot = 0; $slot < 3; $slot++)
                            @if($slot < $shownCount)
                                @php
                                    $schedule = $shownSchedules[$slot];
                                    $now = now();
                                    $status = $schedule->status;
                                    if ($status === 'upcoming' && $schedule->start_time < $now) {
                                        $status = 'completed';
                                    }
                                    $colorMap = [
                                        'upcoming'  => 'bg-emerald-100 border-emerald-300 text-emerald-700',
                                        'completed' => 'bg-slate-100 border-slate-200 text-slate-500',
                                        'cancelled' => 'bg-red-100 border-red-200 text-red-500',
                                    ];
                                    $dotColorMap = [
                                        'upcoming'  => 'bg-emerald-500',
                                        'completed' => 'bg-slate-400',
                                        'cancelled' => 'bg-red-400',
                                    ];
                                    $itemClass = $colorMap[$status] ?? $colorMap['upcoming'];
                                    $dotClass = $dotColorMap[$status] ?? $dotColorMap['upcoming'];
                                @endphp
                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}"
                                   class="block px-2 py-1 h-[22px] rounded-lg border text-[10px] font-bold leading-tight truncate transition-all hover:shadow-md hover:scale-[1.02] cursor-pointer {{ $itemClass }}"
                                   title="{{ $schedule->title }} — {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} | HLV: {{ $schedule->trainer?->user?->name ?? 'N/A' }}">
                                    <div class="flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $dotClass }}"></span>
                                        <span class="truncate">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} {{ $schedule->title }}</span>
                                    </div>
                                </a>
                            @else
                                {{-- Empty spacer to maintain uniform height --}}
                                <div class="h-[22px]"></div>
                            @endif
                        @endfor

                        {{-- Row 4: "View more" button or empty spacer --}}
                        @if($daySchedules->count() > 3)
                            <div class="h-[18px] flex items-center justify-center text-[9px] font-bold text-orange-600 cursor-pointer hover:underline rounded-md hover:bg-orange-50 transition-colors"
                                 x-data
                                 @click="$dispatch('open-day-modal', { date: '{{ $dateKey }}' })">
                                +{{ $daySchedules->count() - 3 }} buổi khác
                            </div>
                        @else
                            <div class="h-[18px]"></div>
                        @endif
                    </div>
                </div>
            @endfor

            {{-- Empty cells after last day of month --}}
            @php
                $lastDayOfWeek = $startOfMonth->copy()->endOfMonth()->dayOfWeek;
                $trailingDays = (6 - $lastDayOfWeek);
            @endphp
            @for($i = 0; $i < $trailingDays; $i++)
                <div class="bg-gray-50/50 border-r border-b border-gray-100 p-2">
                    <div class="h-7"></div>
                    <div class="flex flex-col gap-1">
                        <div class="h-[22px]"></div>
                        <div class="h-[22px]"></div>
                        <div class="h-[22px]"></div>
                        <div class="h-[18px]"></div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    {{-- Legend --}}
    <div class="px-8 py-4 bg-slate-50/50 border-t border-gray-100 flex flex-wrap items-center gap-5 text-[10px] font-bold uppercase tracking-widest text-slate-400">
        <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Sắp diễn ra</div>
        <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span> Đã kết thúc</div>
        <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-400"></span> Đã hủy</div>
        <div class="ml-auto text-slate-300 normal-case tracking-normal italic">Click vào buổi tập để chỉnh sửa</div>
    </div>
</div>

{{-- Day Detail Modal --}}
<div x-data="dayModal()" x-cloak>
    {{-- Backdrop --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm" @click="open = false"></div>

    {{-- Modal --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-8 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg pointer-events-auto max-h-[80vh] flex flex-col overflow-hidden border border-gray-100" @click.away="open = false">
            {{-- Modal Header --}}
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 tracking-tight" x-text="'Lịch ngày ' + displayDate"></h3>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-widest" x-text="countText"></p>
                </div>
                <button @click="open = false" class="w-9 h-9 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-all">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            {{-- Modal Body --}}
            <div class="p-6 overflow-y-auto flex-1 space-y-3" x-ref="modalBody">
                <template x-for="item in items" :key="item.id">
                    <div class="flex items-start gap-3 p-4 rounded-2xl border border-gray-100 hover:shadow-md hover:border-orange-100 transition-all group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg flex-shrink-0 mt-0.5 transition-all duration-300"
                             :class="item.status === 'cancelled' ? 'bg-red-50 text-red-400' : (item.status === 'completed' ? 'bg-slate-100 text-slate-400' : 'bg-emerald-50 text-emerald-600 group-hover:bg-orange-600 group-hover:text-white')">
                            <i :class="item.isYoga ? 'fa-solid fa-yin-yang' : 'fa-solid fa-dumbbell'"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-bold text-slate-900 truncate" x-text="item.title"></div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                                <i class="fa-solid fa-clock mr-0.5"></i>
                                <span x-text="item.time"></span>
                                <span class="mx-1">•</span>
                                <i class="fa-solid fa-user-tie mr-0.5"></i>
                                <span x-text="item.trainer"></span>
                            </div>
                        </div>
                        <div class="flex gap-1.5 flex-shrink-0">
                            <a :href="item.editUrl" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all text-xs shadow-sm">
                                <i class="fa-solid fa-pen-nib"></i>
                            </a>
                            <form :action="item.deleteUrl" method="POST" onsubmit="return confirm('Xác nhận xóa lịch này?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all text-xs shadow-sm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </template>
                <div x-show="items.length === 0" class="text-center py-10">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 text-2xl mx-auto mb-3">
                        <i class="fa-solid fa-calendar-minus"></i>
                    </div>
                    <div class="text-xs text-slate-400 font-bold uppercase tracking-widest">Không có lịch nào trong ngày này</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .scrollbar-thin::-webkit-scrollbar {
        width: 3px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 99px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>

@php
    $modalData = [];
    foreach ($schedulesByDate as $dateKey => $dayItems) {
        $modalData[$dateKey] = [];
        foreach ($dayItems as $s) {
            $sNow = now();
            $sStatus = $s->status;
            if ($sStatus === 'upcoming' && $s->start_time < $sNow) {
                $sStatus = 'completed';
            }
            $modalData[$dateKey][] = [
                'id' => $s->id,
                'title' => $s->title,
                'time' => \Carbon\Carbon::parse($s->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($s->end_time)->format('H:i'),
                'trainer' => $s->trainer?->user?->name ?? 'N/A',
                'status' => $sStatus,
                'isYoga' => str_contains(strtolower($s->title), 'yoga'),
                'editUrl' => route('admin.schedules.edit', $s->id),
                'deleteUrl' => route('admin.schedules.delete', $s->id),
            ];
        }
    }
@endphp
<script>
    const allSchedulesByDate = @json($modalData);

    function dayModal() {
        return {
            open: false,
            items: [],
            displayDate: '',
            countText: '',
            init() {
                window.addEventListener('open-day-modal', (e) => {
                    const dateKey = e.detail.date;
                    this.items = allSchedulesByDate[dateKey] || [];
                    // Format date for display
                    const parts = dateKey.split('-');
                    this.displayDate = parts[2] + '/' + parts[1] + '/' + parts[0];
                    this.countText = this.items.length + ' buổi tập';
                    this.open = true;
                });
            }
        };
    }
</script>
@endsection

