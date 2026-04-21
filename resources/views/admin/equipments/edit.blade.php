@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Cập nhật Dụng cụ')

@section('content')
<div class="mb-6 flex items-center gap-4 z-10 relative">
    <a href="{{ route('equipments.index') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-gray-50 transition-colors shadow-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight uppercase">Cập nhật Dụng cụ</h2>
        <p class="text-sm text-slate-500 mt-1 uppercase tracking-widest">Sửa thông tin: {{ $equipment->name }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10 max-w-2xl">
    <div class="p-6">
        <form action="{{ route('equipments.update', $equipment->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Tên dụng cụ -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-widest mb-2">Tên dụng cụ <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $equipment->name) }}" placeholder="VD: Máy chạy bộ m800" 
                           class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none text-slate-700 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trạng thái -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-widest mb-2">Trạng thái <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="status" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none appearance-none text-slate-700 @error('status') border-red-500 @enderror">
                            <option value="active" {{ old('status', $equipment->status) == 'active' ? 'selected' : '' }}>🟢 Hoạt động</option>
                            <option value="maintenance" {{ old('status', $equipment->status) == 'maintenance' ? 'selected' : '' }}>🟠 Đang Bảo trì</option>
                            <option value="broken" {{ old('status', $equipment->status) == 'broken' ? 'selected' : '' }}>🔴 Bị Hỏng</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ngày bảo trì -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-widest mb-2">Ngày bảo trì (Tùy chọn)</label>
                    <input type="date" name="last_maintained_at" value="{{ old('last_maintained_at', $equipment->last_maintained_at ? \Carbon\Carbon::parse($equipment->last_maintained_at)->format('Y-m-d') : '') }}" 
                           class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none text-slate-700">
                </div>

                <!-- Mô tả -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-widest mb-2">Mô tả thêm (Tùy chọn)</label>
                    <textarea name="description" rows="4" placeholder="Nhập ghi chú hoặc mô tả về dụng cụ..." 
                              class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 rounded-xl px-4 py-3 text-sm transition-all outline-none resize-none text-slate-700">{{ old('description', $equipment->description) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex gap-3 pt-6 border-t border-gray-100">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-lg shadow-indigo-600/30 text-sm uppercase tracking-widest hover:-translate-y-0.5">
                    Lưu Thay đổi
                </button>
                <a href="{{ route('equipments.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-6 py-3 rounded-xl font-medium transition-colors text-sm uppercase tracking-widest">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

