@extends('layouts.admin')

@section('title', 'Quản lý Hashtags')

@section('content')
<div class="space-y-6">
    <!-- Header Area -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Hashtags Tin tức</h2>
            <p class="text-sm text-slate-500 mt-1">Quản lý các thẻ (tags) phân loại bài viết</p>
        </div>
        <button onclick="openCreateModal()" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-orange-600/30 transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Thêm Hashtag mới
        </button>
    </div>

    <!-- Tags List -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tên Hashtag</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ngày tạo</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tags as $tag)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-600 font-medium">#{{ $tag->id }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-full">#{{ $tag->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $tag->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.news.tags.delete', $tag->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hashtag này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors inline-flex items-center justify-center">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-tags text-4xl text-slate-300 mb-3"></i>
                                    <p>Chưa có hashtag nào.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($tags->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $tags->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="fixed inset-0 z-[100] bg-slate-900/50 backdrop-blur-sm flex items-center justify-center hidden opacity-0 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md transform scale-95 transition-transform" id="createModalContent">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Thêm Hashtag Mới</h3>
            <button onclick="closeCreateModal()" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form action="{{ route('admin.news.tags.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tên Hashtag <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-2.5 text-slate-400 font-bold">#</span>
                        <input type="text" name="name" required class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all" placeholder="Nhập tên tag (không có dấu #)...">
                    </div>
                </div>
            </div>
            <div class="p-6 pt-0 flex justify-end gap-3">
                <button type="button" onclick="closeCreateModal()" class="px-5 py-2.5 rounded-xl text-slate-600 font-semibold hover:bg-slate-100 transition-colors">Hủy</button>
                <button type="submit" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-xl shadow-lg shadow-orange-600/30 transition-all">Lưu</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        const modal = document.getElementById('createModal');
        const content = document.getElementById('createModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
    }

    function closeCreateModal() {
        const modal = document.getElementById('createModal');
        const content = document.getElementById('createModalContent');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
