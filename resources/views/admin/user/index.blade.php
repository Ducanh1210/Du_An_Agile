@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')
<!-- Header Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 uppercase tracking-tighter">
    <!-- Stat Card 1 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed">Tổng người dùng</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $listUser->total() }}</div>
        </div>
        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed">Admin / Staff</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $listUser->whereIn('role', ['admin', 'staff'])->count() }}</div>
        </div>
        <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-user-shield"></i>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed">Huấn luyện viên</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $listUser->where('role', 'trainer')->count() }}</div>
        </div>
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-user-tie"></i>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 leading-relaxed">Khách hàng</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $listUser->where('role', 'user')->count() }}</div>
        </div>
        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-user-group"></i>
        </div>
    </div>
</div>

<!-- Main Table Card -->
<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden leading-relaxed">
    <!-- Table Toolbar -->
    <div class="px-8 py-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight leading-normal">Danh sách tài khoản hệ thống</h2>
            <p class="text-sm text-slate-400 font-medium tracking-tighter uppercase">Quản lý phân quyền và thông tin người dùng.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('users.create') }}" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-600/20 hover:bg-blue-700 hover:scale-105 active:scale-95 transition-all">
                <i class="fa-solid fa-user-plus mr-2"></i> Thêm người dùng mới
            </a>
        </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Người dùng</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Email</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Vai trò</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Ngày tạo</th>
                    <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em] text-center">Tương tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($listUser as $user)
                <tr class="hover:bg-slate-50/80 transition-colors group leading-relaxed">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-all duration-300">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900 leading-normal">{{ $user->name }}</div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">ID: #{{ $user->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-sm font-medium text-slate-600 italic">
                        {{ $user->email }}
                    </td>
                    <td class="px-8 py-5">
                        @php
                            $roleClasses = [
                                'admin' => 'bg-red-50 text-red-600 border-red-100',
                                'staff' => 'bg-orange-50 text-orange-600 border-orange-100',
                                'trainer' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'user' => 'bg-blue-50 text-blue-600 border-blue-100',
                            ];
                            $roleClass = $roleClasses[$user->role] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                        @endphp
                        <span class="px-3 py-1 {{ $roleClass }} rounded-lg text-[10px] font-bold uppercase tracking-widest border shadow-sm leading-normal inline-block">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-sm font-bold text-slate-500">
                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : '---' }}
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center justify-center gap-2">
                             <a href="{{ route('users.edit', $user->id) }}" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm shadow-blue-600/10">
                                 <i class="fa-solid fa-user-pen text-sm"></i>
                             </a>
                             @if($user->id != 1 && $user->id != auth()->id())
                             <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa người dùng này?')" class="inline">
                                 @csrf @method('DELETE')
                                 <button type="submit" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300 shadow-sm shadow-red-600/10">
                                     <i class="fa-solid fa-user-minus text-sm"></i>
                                 </button>
                             </form>
                             @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($listUser->hasPages())
    <div class="px-8 py-5 bg-slate-50/50 border-t border-gray-100">
        {{ $listUser->links() }}
    </div>
    @endif
</div>
@endsection
