@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Danh sách Gói tập')

@section('content')
<!-- Header Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 uppercase tracking-tighter">
    <!-- Stat Card 1 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed">Tổng Gói tập</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $listMem->total() }}</div>
        </div>
        <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-tags"></i>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed tracking-widest">Gói Gym</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose tracking-widest">{{ $listMem->where('category', 'gym')->count() }}</div>
        </div>
        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-dumbbell"></i>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed">Gói Yoga</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $listMem->where('category', 'yoga')->count() }}</div>
        </div>
        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-yin-yang"></i>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed whitespace-nowrap">Đang kích hoạt</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $listMem->where('is_active', 1)->count() }}</div>
        </div>
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-circle-check"></i>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden leading-relaxed">
    <!-- Table Toolbar -->
    <div class="px-8 py-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight leading-normal">Kho dữ liệu các Gói Fitness</h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.memberships.create') }}" class="px-6 py-2.5 bg-orange-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-orange-600/20 hover:bg-orange-700 hover:scale-105 active:scale-95 transition-all">
                <i class="fa-solid fa-plus mr-2"></i> Thêm gói tập ngay
            </a>
        </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Thông tin gói tập</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Phân loại môn</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Thời hạn học</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Giá niêm yết</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Trạng thái</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em] text-center">Tương tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($listMem as $mem)
                <tr class="hover:bg-slate-50/80 transition-colors group leading-relaxed">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-slate-400 group-hover:bg-primary/10 group-hover:text-primary transition-all duration-300">
                                <i class="fa-solid {{ $mem->category == 'gym' ? 'fa-dumbbell' : 'fa-yin-yang' }}"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-normal">{{ $mem->name }}</div>
                                <div class="text-[11px] font-bold text-slate-400 flex items-center gap-1.5 mt-0.5 whitespace-nowrap">
                                    @if($mem->allow_pt)
                                    <i class="fa-solid fa-user-check text-orange-500"></i> Kèm {{ $mem->pt_sessions }} buổi PT hướng dẫn
                                    @else
                                    <i class="fa-solid fa-user text-slate-300"></i> Khách hàng tự tập tự do
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        @if($mem->category == 'gym')
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-blue-100 shadow-sm leading-normal inline-block  tracking-tighter uppercase">Fitness / Gym</span>
                        @else
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-purple-100 shadow-sm leading-normal inline-block  tracking-tighter uppercase">Therapy / Yoga</span>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-2 tracking-normal uppercase tracking-tighter ">
                             <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                             <span class="text-sm font-bold text-slate-600 uppercase tracking-tighter  tracking-widest">{{ $mem->duration_days }} ngày liên tục</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 tracking-widest uppercase tracking-tighter ">
                        <div class="text-sm font-bold text-slate-900 tracking-tight leading-normal">{{ number_format($mem->price, 0, ',', '.') }} <span class="text-[10px] text-slate-400 ml-0.5 uppercase tracking-tighter  uppercase">VND</span></div>
                    </td>
                    <td class="px-8 py-5 tracking-widest uppercase tracking-tighter ">
                        @if($mem->is_active)
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-bold uppercase tracking-wide border border-emerald-100 shadow-sm leading-normal">
                             <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                             Đang kinh doanh
                        </div>
                        @else
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-100 text-slate-400 rounded-full text-[10px] font-bold uppercase tracking-wide border border-slate-200 leading-normal tracking-widest uppercase tracking-tighter ">
                             <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                             Tạm ngừng
                        </div>
                        @endif
                    </td>
                    <td class="px-8 py-5 tracking-widest uppercase tracking-tighter ">
                        <div class="flex items-center justify-center gap-2">
                             <a href="{{ route('admin.memberships.edit', $mem->id) }}" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm shadow-blue-600/10">
                                 <i class="fa-solid fa-pen-nib text-sm"></i>
                             </a>
                             <form action="{{ route('admin.memberships.delete', $mem->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa gói tập này?')" class="inline">
                                 @csrf @method('DELETE')
                                 <button type="submit" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm shadow-red-600/10  uppercase tracking-tighter">
                                     <i class="fa-solid fa-trash-can text-sm"></i>
                                 </button>
                             </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($listMem->hasPages())
    <div class="px-8 py-5 bg-slate-50/50 border-t border-gray-100">
        {{ $listMem->links() }}
    </div>
    @endif
</div>
@endsection

