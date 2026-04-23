@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Quản lý Danh mục Tin tức')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Form --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden sticky top-8">
            <div class="px-8 py-6 border-b border-gray-50">
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Thêm Danh mục</h2>
                <p class="text-sm text-slate-400 mt-0.5">Tạo danh mục mới cho bài viết</p>
            </div>
            
            <form action="{{ route('admin.news.categories.store') }}" method="POST" class="p-8 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tên danh mục <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="VD: Sức khỏe, Dinh dưỡng..."
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Mô tả</label>
                    <textarea name="description" rows="3" placeholder="Mô tả về danh mục..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all resize-none"></textarea>
                </div>
                <button type="submit" 
                        class="w-full py-3 bg-orange-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-orange-600/20 hover:bg-orange-700 hover:scale-[1.02] active:scale-95 transition-all">
                    <i class="fa-solid fa-plus mr-2"></i> Lưu danh mục
                </button>
            </form>
        </div>
    </div>

    {{-- List --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-50">
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Danh sách Danh mục</h2>
                <p class="text-sm text-slate-400 mt-0.5">Tổng cộng {{ $categories->total() }} danh mục</p>
            </div>

            @if(session('success'))
            <div class="mx-8 mt-6 px-5 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Danh mục</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Số bài viết</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em] text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $cat)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-8 py-5">
                                <div class="font-bold text-slate-900 text-sm">{{ $cat->name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $cat->description ?: 'Không có mô tả' }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 bg-orange-50 text-orange-600 rounded-lg text-xs font-bold border border-orange-100 italic">
                                    {{ $cat->news_count }} bài viết
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick='openEditModal(@json($cat))'
                                            class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300">
                                        <i class="fa-solid fa-pen-nib text-sm"></i>
                                    </button>
                                    <form action="{{ route('admin.news.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Xóa danh mục này?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-12 text-center text-slate-400">Chưa có danh mục nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
            <div class="px-8 py-5 bg-slate-50/50 border-t border-gray-100">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Simple Edit Modal Placeholder --}}
<div id="editModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-[32px] w-full max-w-md shadow-2xl p-8 transform scale-95 transition-transform duration-300">
        <h3 class="text-xl font-bold text-slate-900 mb-6">Chỉnh sửa Danh mục</h3>
        <form id="editForm" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tên danh mục</label>
                <input type="text" name="name" id="editName" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Mô tả</label>
                <textarea name="description" id="editDesc" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 resize-none"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 py-3 bg-orange-600 text-white rounded-xl font-bold text-sm hover:bg-orange-700 transition-all">Cập nhật</button>
                <button type="button" onclick="closeEditModal()" class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-all">Hủy</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEditModal(cat) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    document.getElementById('editName').value = cat.name;
    document.getElementById('editDesc').value = cat.description || '';
    form.action = `{{ url('admin/news/categories') }}/${cat.id}`;
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.querySelector('div').classList.remove('scale-95');
    }, 10);
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('opacity-0');
    modal.querySelector('div').classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}
</script>
@endpush
@endsection

