@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Quản lý Tin tức')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5">Tổng tin tức</div>
            <div class="text-3xl font-bold text-slate-900">{{ $news->total() }}</div>
        </div>
        <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-newspaper"></i>
        </div>
    </div>
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5">Công khai</div>
            <div class="text-3xl font-bold text-slate-900">{{ $news->where('news_status', 'published')->count() }}</div>
        </div>
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-circle-check"></i>
        </div>
    </div>
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5">Chờ duyệt</div>
            <div class="text-3xl font-bold text-slate-900">{{ $news->where('news_status', 'pending')->count() }}</div>
        </div>
        <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-clock"></i>
        </div>
    </div>
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5">Bản nháp/Ẩn</div>
            <div class="text-3xl font-bold text-slate-900">{{ $news->whereIn('news_status', ['draft', 'hidden'])->count() }}</div>
        </div>
        <div class="w-14 h-14 bg-slate-100 text-slate-500 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-slate-500 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-file-pen"></i>
        </div>
    </div>
</div>

{{-- Table Card --}}
<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
    {{-- Toolbar --}}
    <div class="px-8 py-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Danh sách Tin tức</h2>
            <p class="text-sm text-slate-400 mt-0.5">Quản lý bài viết và tin tức trên website theo chuẩn SQL Dump</p>
        </div>
        <a href="{{ route('admin.news.create') }}"
           class="px-6 py-2.5 bg-orange-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-orange-600/20 hover:bg-orange-700 hover:scale-105 active:scale-95 transition-all inline-flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Thêm tin tức
        </a>
    </div>

    @if(session('success'))
    <div class="mx-8 mt-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Bài viết</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Danh mục</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Tiêu điểm</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Trạng thái</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Lượt xem</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em] text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($news as $item)
                <tr class="hover:bg-slate-50/80 transition-colors group">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                     class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                                @else
                                <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-newspaper text-orange-400 text-lg"></i>
                                </div>
                                @endif
                                @if($item->is_featured)
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-orange-500 rounded-full border-2 border-white flex items-center justify-center">
                                    <i class="fa-solid fa-star text-[8px] text-white"></i>
                                </span>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-normal line-clamp-1 max-w-xs">{{ $item->title }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5 font-mono">{{ $item->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold uppercase tracking-wider border border-blue-100 shadow-sm">
                            {{ optional($item->category)->name ?: 'Chung' }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        @if($item->is_featured)
                        <span class="text-orange-500 font-bold text-[10px] uppercase tracking-tighter bg-orange-50 px-2 py-0.5 rounded border border-orange-100">Featured</span>
                        @else
                        <span class="text-slate-300 text-[10px] uppercase tracking-tighter">Normal</span>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        @switch($item->news_status)
                            @case('published')
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-bold uppercase tracking-wide border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span> Công khai
                                </div>
                                @break
                            @case('pending')
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-bold uppercase tracking-wide border border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> Chờ duyệt
                                </div>
                                @break
                            @case('hidden')
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-rose-50 text-rose-600 rounded-full text-[10px] font-bold uppercase tracking-wide border border-rose-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span> Đã ẩn
                                </div>
                                @break
                            @default
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-100 text-slate-400 rounded-full text-[10px] font-bold uppercase tracking-wide border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Bản nháp
                                </div>
                        @endswitch
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-1.5">
                            <i class="fa-solid fa-eye text-slate-300 text-xs"></i>
                            <span class="text-sm text-slate-600 font-bold tabular-nums">{{ number_format($item->views) }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.news.edit', $item->id) }}"
                               class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm border border-blue-100">
                                <i class="fa-solid fa-pen-nib text-sm"></i>
                            </a>
                            <form action="{{ route('admin.news.delete', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Xác nhận xóa bài viết này?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm border border-red-100">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-16 text-center text-slate-400">
                        <i class="fa-solid fa-newspaper text-4xl opacity-30 block mb-3"></i>
                        <p class="font-semibold">Chưa có tin tức nào</p>
                        <a href="{{ route('admin.news.create') }}" class="text-orange-500 hover:underline text-sm mt-1 inline-block">Tạo bài viết đầu tiên →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($news->hasPages())
    <div class="px-8 py-5 bg-slate-50/50 border-t border-gray-100">
        {{ $news->links() }}
    </div>
    @endif
</div>
@endsection

