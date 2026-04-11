@extends('layouts.admin')

@section('title', 'Bảng điều khiển Tổng quan')

@section('content')
<!-- Header Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 uppercase tracking-tighter">
    <!-- Stat Card 1: Total Users -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 ">Hội viên mới</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $total_users }}</div>
        </div>
        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <!-- Stat Card 2: Total Memberships -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 ">Gói tập Fitness</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $total_memberships }}</div>
        </div>
        <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-tags"></i>
        </div>
    </div>

    <!-- Stat Card 3: Total Staff/Trainers -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 ">Nhân sự & PT</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $total_staff }}</div>
        </div>
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-user-tie"></i>
        </div>
    </div>

    <!-- Stat Card 4: Active Memberships -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 ">Đang kinh doanh</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose text-emerald-600">{{ $active_memberships }}</div>
        </div>
        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-circle-check"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Quick Dashboard Summary -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden leading-relaxed">
            <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight ">Đăng ký tài khoản mới gần đây</h2>
                    <p class="text-sm text-slate-400 font-medium tracking-tighter uppercase whitespace-nowrap">Danh sách 5 tài khoản đăng ký mới nhất hệ thống.</p>
                </div>
                <a href="{{ route('users.index') }}" class="text-blue-600 font-bold text-xs uppercase tracking-widest hover:underline">Xem tất cả</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Hội viên</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Quyền hạn</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-[.2em]">Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($latest_users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gray-100 flex items-center justify-center text-slate-400">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900 leading-normal">{{ $user->name }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-2.5 py-0.5 bg-slate-50 text-slate-600 rounded-lg text-[10px] font-bold uppercase border border-slate-100">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-xs font-bold text-slate-500">
                                {{ $user->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Quick Links & Summary -->
    <div class="space-y-6">
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight mb-6">Truy cập nhanh</h2>
            <div class="space-y-4">
                <a href="{{ route('memberships.create') }}" class="flex items-center justify-between p-4 bg-orange-50 border border-orange-100 rounded-2xl group hover:bg-orange-600 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white text-orange-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 group-hover:text-white">Thêm Gói tập</div>
                            <div class="text-[10px] text-slate-400 group-hover:text-orange-100">Cập nhật dịch vụ mới</div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('users.create') }}" class="flex items-center justify-between p-4 bg-blue-50 border border-blue-100 rounded-2xl group hover:bg-blue-600 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white text-blue-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 group-hover:text-white">Tạo User mới</div>
                            <div class="text-[10px] text-slate-400 group-hover:text-blue-100">Thêm nhân viên/hội viên</div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl group hover:bg-slate-900 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white text-slate-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-gears"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 group-hover:text-white">Cài đặt cá nhân</div>
                            <div class="text-[10px] text-slate-400 group-hover:text-slate-300">Thay đổi thông tin Admin</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
