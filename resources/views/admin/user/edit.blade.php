@extends('layouts.admin')

@section('title', 'Cập nhật người dùng')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight leading-normal uppercase tracking-tighter">Sửa thông tin tài khoản: #{{ $userDetail->id }}</h2>
            <a href="{{ route('users.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest tracking-tighter">
                <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại
            </a>
        </div>

        <form action="{{ route('users.update', $userDetail->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-2 uppercase tracking-tighter">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest tracking-tighter ml-1">Họ và tên</label>
                    <input type="text" name="name" 
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none"
                        placeholder="Nhập tên người dùng..." value="{{ old('name', $userDetail->name) }}">
                    @error('name') <span class="text-[11px] font-bold text-red-500 ml-1 uppercase tracking-tighter">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2 uppercase tracking-tighter">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest tracking-tighter ml-1">Địa chỉ Email</label>
                    <input type="email" name="email" 
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none"
                        placeholder="example@gmail.com" value="{{ old('email', $userDetail->email) }}">
                    @error('email') <span class="text-[11px] font-bold text-red-500 ml-1 uppercase tracking-tighter">{{ $message }}</span> @enderror
                </div>

                <!-- Role -->
                <div class="space-y-2 uppercase tracking-tighter">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest tracking-tighter ml-1">Vai trò hệ thống</label>
                    <select name="role" 
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none appearance-none">
                        <option value="user" {{ old('role', $userDetail->role) == 'user' ? 'selected' : '' }}>Khách hàng (User)</option>
                        <option value="trainer" {{ old('role', $userDetail->role) == 'trainer' ? 'selected' : '' }}>Huấn luyện viên (Trainer)</option>
                        <option value="staff" {{ old('role', $userDetail->role) == 'staff' ? 'selected' : '' }}>Nhân viên (Staff)</option>
                        <option value="admin" {{ old('role', $userDetail->role) == 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                    </select>
                    @error('role') <span class="text-[11px] font-bold text-red-500 ml-1 uppercase tracking-tighter">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2 uppercase tracking-tighter">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest tracking-tighter ml-1">Mật khẩu (Để trống nếu không đổi)</label>
                    <input type="password" name="password" 
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none"
                        placeholder="Bỏ qua nếu giữ nguyên mật khẩu cũ...">
                    @error('password') <span class="text-[11px] font-bold text-red-500 ml-1 uppercase tracking-tighter">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 flex items-center justify-end gap-3 uppercase tracking-tighter">
                <a href="{{ route('users.index') }}" class="px-8 py-3 bg-slate-100 text-slate-500 rounded-2xl font-bold text-sm hover:bg-slate-200 active:scale-95 transition-all uppercase tracking-tighter">
                    Hủy bỏ
                </a>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-600/20 hover:bg-blue-700 hover:scale-105 active:scale-95 transition-all tracking-widest uppercase tracking-tighter">
                    Cập nhật ngay
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
