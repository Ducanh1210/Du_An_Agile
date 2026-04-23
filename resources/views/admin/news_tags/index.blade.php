@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Quản lý Thẻ Tin tức')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Form --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden sticky top-8">
            <div class="px-8 py-6 border-b border-gray-50">
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Thêm Thẻ (Tag)</h2>
                <p class="text-sm text-slate-400 mt-0.5">Tạo các từ khóa cho bài viết</p>
            </div>
            
            <form action="{{ route('admin.news.tags.store') }}" method="POST" class="p-8 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tên thẻ <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="VD: Fitness, Yoga, Khuyến mãi..."
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all">
                </div>
                <button type="submit" 
                        class="w-full py-3 bg-orange-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-orange-600/20 hover:bg-orange-700 hover:scale-[1.02] active:scale-95 transition-all">
                    <i class="fa-solid fa-tag mr-2"></i> Lưu thẻ tag
                </button>
            </form>
        </div>
    </div>

    {{-- List --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-50">
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Danh sách Thẻ</h2>
                <p class="text-sm text-slate-400 mt-0.5">Quản lý tổng cộng {{ $tags->total() }} thẻ tag</p>
            </div>

            @if(session('success'))
            <div class="mx-8 mt-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
            @endif

            <div class="p-8">
                <div class="flex flex-wrap gap-3">
                    @forelse($tags as $tag)
                    <div class="group relative flex items-center gap-2 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl hover:bg-orange-50 hover:border-orange-200 transition-all duration-300">
                        <span class="text-sm font-bold text-slate-700 group-hover:text-orange-600 transition-colors uppercase tracking-tight">#{{ $tag->name }}</span>
                        <span class="px-1.5 py-0.5 bg-white border border-slate-100 rounded-lg text-[10px] text-slate-400 font-bold italic">{{ $tag->news_count }} bài</span>
                        
                        <form action="{{ route('admin.news.tags.delete', $tag->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa thẻ này?')"
                                    class="text-slate-300 hover:text-red-500 transition-colors ml-1">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="text-center w-full py-12 text-slate-400">
                        <i class="fa-solid fa-tags text-4xl opacity-20 block mb-2"></i>
                        Chưa có thẻ tag nào
                    </div>
                    @endforelse
                </div>
            </div>

            @if($tags->hasPages())
            <div class="px-8 py-5 bg-slate-50/50 border-t border-gray-100">
                {{ $tags->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

