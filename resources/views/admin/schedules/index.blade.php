@extends('layouts.admin')

@section('title', 'Quản lý lịch học')

@section('content')
<!-- Header Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 uppercase tracking-tighter">
    <!-- Stat Card 1 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed">Tổng lịch học</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $stats['countAll'] }}</div>
        </div>
        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed">Hôm nay</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $stats['countToday'] }}</div>
        </div>
        <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-clock"></i>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed">Sắp diễn ra</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose text-emerald-600">{{ $stats['countUpcoming'] }}</div>
        </div>
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-flag-checkered"></i>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed">Đã hủy</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose text-red-500">{{ $stats['countCancelled'] }}</div>
        </div>
        <div class="w-14 h-14 bg-red-100 text-red-400 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-calendar-xmark"></i>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden leading-relaxed">
    <!-- Table Toolbar -->
    <div class="px-8 py-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight leading-normal">Kế hoạch Lớp học & PT Session</h2>
            <p class="text-sm text-slate-400 font-medium tracking-tighter uppercase whitespace-nowrap">Theo dõi và điều phối lịch trình huấn luyện toàn hệ thống.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.schedules.create') }}" class="px-6 py-2.5 bg-orange-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-orange-600/20 hover:bg-orange-700 hover:scale-105 active:scale-95 transition-all">
                <i class="fa-solid fa-plus mr-2"></i> Thêm lịch mới
            </a>
        </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Buổi tập / Lớp</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Huấn luyện viên</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Thời hạn thời gian</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Trạng thái</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em] text-center">Tương tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($schedules as $schedule)
                <tr class="hover:bg-slate-50/80 transition-colors group leading-relaxed">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-orange-600 group-hover:text-white transition-all duration-300">
                                <i class="fa-solid {{ Str::contains(strtolower($schedule->title), 'yoga') ? 'fa-yin-yang' : 'fa-dumbbell' }}"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-normal">{{ $schedule->title }}</div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter italic">Phòng: {{ $schedule->room ?? 'Chưa xác định' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-user-tie text-[10px] text-slate-300"></i>
                            <span class="text-sm font-bold text-slate-600">{{ $schedule->trainer?->user?->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex flex-col gap-0.5">
                            <div class="text-sm font-bold text-slate-900 tracking-tight">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('d \t\h\g m, Y') }}
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        @php
                            $now = now();
                            $status = $schedule->status;
                            
                            // Tự động chuyển sang "Đã kết thúc" nếu thời gian đã trôi qua
                            if ($status === 'upcoming' && $schedule->start_time < $now) {
                                $status = 'completed';
                            }

                            $statusClasses = [
                                'upcoming' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'completed' => 'bg-slate-50 text-slate-500 border-slate-100',
                                'cancelled' => 'bg-red-50 text-red-500 border-red-100',
                            ];
                            $statusLabels = [
                                'upcoming' => 'Sắp diễn ra',
                                'completed' => 'Đã kết thúc',
                                'cancelled' => 'Đã hủy bỏ',
                            ];
                            $class = $statusClasses[$status] ?? $statusClasses['upcoming'];
                            $label = $statusLabels[$status] ?? $status;
                        @endphp
                        <span class="px-3 py-1 {{ $class }} rounded-lg text-[10px] font-bold uppercase tracking-widest border shadow-sm leading-normal inline-block">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center gap-2">
                             <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm shadow-blue-600/10">
                                 <i class="fa-solid fa-pen-nib text-sm"></i>
                             </a>
                             <form action="{{ route('admin.schedules.delete', $schedule->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa lịch này?')" class="inline">
                                 @csrf @method('DELETE')
                                 <button type="submit" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm shadow-red-600/10">
                                     <i class="fa-solid fa-trash-can text-sm"></i>
                                 </button>
                             </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 text-3xl">
                                <i class="fa-solid fa-calendar-minus"></i>
                            </div>
                            <div class="text-slate-400 font-bold uppercase tracking-widest text-xs italic">Hiện tại chưa có lịch lớp nào được thiết lập.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($schedules->hasPages())
    <div class="px-8 py-5 bg-slate-50/50 border-t border-gray-100">
        {{ $schedules->links() }}
    </div>
    @endif
</div>
@endsection
