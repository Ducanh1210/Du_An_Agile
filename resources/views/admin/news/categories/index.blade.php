@extends('layouts.admin')

@section('title', 'Quản lý Danh mục Tin tức')

@section('content')
<div class="space-y-6">
    <!-- Header Area -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Danh mục Tin tức</h2>
            <p class="text-sm text-slate-500 mt-1">Quản lý và phân loại các bài viết tin tức</p>
        </div>
        <button onclick="openCreateModal()" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-orange-600/30 transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Thêm danh mục mới
        </button>
    </div>

    <!-- Categories List -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tên danh mục</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-600 font-medium">#{{ $category->id }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-800">{{ $category->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $category->slug }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button onclick="openEditModal({{ $category->id }}, '{{ $category->name }}')" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors inline-flex items-center justify-center">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                
                                <form action="{{ route('admin.news.categories.delete', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
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
                                    <i class="fa-regular fa-folder-open text-4xl text-slate-300 mb-3"></i>
                                    <p>Chưa có danh mục nào.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="fixed inset-0 z-[100] bg-slate-900/50 backdrop-blur-sm flex items-center justify-center hidden opacity-0 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md transform scale-95 transition-transform" id="createModalContent">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Thêm Danh Mục Mới</h3>
            <button onclick="closeCreateModal()" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form action="{{ route('admin.news.categories.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tên danh mục <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all" placeholder="Nhập tên danh mục...">
                </div>
            </div>
            <div class="p-6 pt-0 flex justify-end gap-3">
                <button type="button" onclick="closeCreateModal()" class="px-5 py-2.5 rounded-xl text-slate-600 font-semibold hover:bg-slate-100 transition-colors">Hủy</button>
                <button type="submit" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-xl shadow-lg shadow-orange-600/30 transition-all">Lưu danh mục</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-[100] bg-slate-900/50 backdrop-blur-sm flex items-center justify-center hidden opacity-0 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md transform scale-95 transition-transform" id="editModalContent">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Chỉnh Sửa Danh Mục</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tên danh mục <span class="text-red-500">*</span></label>
                    <input type="text" id="editName" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all">
                </div>
            </div>
            <div class="p-6 pt-0 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-xl text-slate-600 font-semibold hover:bg-slate-100 transition-colors">Hủy</button>
                <button type="submit" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-xl shadow-lg shadow-orange-600/30 transition-all">Cập nhật</button>
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

    function openEditModal(id, name) {
        const modal = document.getElementById('editModal');
        const content = document.getElementById('editModalContent');
        const form = document.getElementById('editForm');
        const nameInput = document.getElementById('editName');
        
        form.action = `/admin/news/categories/${id}`;
        nameInput.value = name;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        }, 10);
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const content = document.getElementById('editModalContent');
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
