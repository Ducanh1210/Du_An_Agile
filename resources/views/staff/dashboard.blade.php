@extends('layouts.staff')

@section('title', 'Bảng điều khiển Tổng quan')

@section('content')
<!-- Header Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 uppercase tracking-tighter">
    <!-- Stat Card 2: Total Memberships -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 ">Tổng số gói tập</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose">{{ $total_memberships }}</div>
        </div>
        <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-tags"></i>
        </div>
    </div>

    <!-- Stat Card 4: Active Memberships -->
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 ">Gói đang hoạt động</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose text-emerald-600">{{ $active_memberships }}</div>
        </div>
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-circle-check"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 ">Tổng lịch tập</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose text-blue-600">{{ $total_schedules }}</div>
        </div>
        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5 ">Lịch tập hôm nay</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose text-purple-600">{{ $today_schedules }}</div>
        </div>
        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-clock"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Quick Dashboard Summary -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-8 flex flex-col justify-center text-center py-20">
            <div class="w-20 h-20 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fa-solid fa-dumbbell"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Xin chào Nhân viên!</h2>
            <p class="text-slate-500 font-medium">Bảng điều khiển của bạn để quản lý các dịch vụ phòng tập, lịch lớp và tin tức một cách hiệu quả.</p>
        </div>
    </div>

    <!-- Right Column: Quick Links & Summary -->
    <div class="space-y-6">
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight mb-6">Truy cập nhanh</h2>
            <div class="space-y-4">
                <a href="{{ route('admin.memberships.create') }}" class="flex items-center justify-between p-4 bg-orange-50 border border-orange-100 rounded-2xl group hover:bg-orange-600 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white text-orange-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 group-hover:text-white">Thêm Gói tập</div>
                            <div class="text-[10px] text-slate-400 group-hover:text-orange-100">Cập nhật dịch vụ mới</div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.schedules.create') }}" class="flex items-center justify-between p-4 bg-blue-50 border border-blue-100 rounded-2xl group hover:bg-blue-600 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white text-blue-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-calendar-plus"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 group-hover:text-white">Tạo Lịch tập</div>
                            <div class="text-[10px] text-slate-400 group-hover:text-blue-100">Lên lịch các lớp học mới</div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.news.create') }}" class="flex items-center justify-between p-4 bg-purple-50 border border-purple-100 rounded-2xl group hover:bg-purple-600 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white text-purple-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 group-hover:text-white">Thêm Tin tức</div>
                            <div class="text-[10px] text-slate-400 group-hover:text-purple-100">Cập nhật tin tức mới nhất</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
