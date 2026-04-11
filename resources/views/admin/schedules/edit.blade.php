@extends('layouts.admin')

@section('title', 'Cập nhật lịch tập')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center text-sm font-bold text-slate-400 hover:text-orange-600 transition-colors mb-6 group">
        <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
        QUAY LẠI DANH SÁCH
    </a>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 bg-slate-50/50 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Chỉnh sửa Lịch học / PT Session</h2>
                <p class="text-sm text-slate-400 font-medium uppercase tracking-tighter">Cập nhật thông tin chi tiết cho buổi tập ID: #{{ $schedule->id }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-sm shadow-blue-600/10">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>

        <div class="p-8">
            <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Title Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Tiêu đề buổi tập / Tên lớp</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-orange-600 transition-colors">
                            <i class="fa-solid fa-heading"></i>
                        </div>
                        <input type="text" name="title" 
                               class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-orange-600/5 focus:border-orange-600 focus:bg-white transition-all outline-none font-medium @error('title') border-red-500 @enderror" 
                               placeholder="VD: Yoga Flow, Boxing PT, Cardio..." value="{{ old('title', $schedule->title) }}" required>
                    </div>
                    @error('title') <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p> @enderror
                </div>

                <!-- Trainer Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Huấn luyện viên phụ trách</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-orange-600 transition-colors">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <select name="trainer_id" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-orange-600/5 focus:border-orange-600 focus:bg-white transition-all outline-none font-medium appearance-none @error('trainer_id') border-red-500 @enderror" required>
                            @foreach($trainers as $trainer)
                                <option value="{{ $trainer->id }}" {{ old('trainer_id', $schedule->trainer_id) == $trainer->id ? 'selected' : '' }}>
                                    {{ $trainer->user->name }} ({{ $trainer->specialization }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    @error('trainer_id') <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Time -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Thời gian bắt đầu</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-orange-600 transition-colors">
                                <i class="fa-solid fa-calendar-plus"></i>
                            </div>
                            <input type="datetime-local" name="start_time" 
                                   class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-orange-600/5 focus:border-orange-600 focus:bg-white transition-all outline-none font-medium @error('start_time') border-red-500 @enderror" 
                                   value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d\TH:i')) }}" required>
                        </div>
                        @error('start_time') <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Thời gian kết thúc</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-orange-600 transition-colors">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <input type="datetime-local" name="end_time" 
                                   class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-orange-600/5 focus:border-orange-600 focus:bg-white transition-all outline-none font-medium @error('end_time') border-red-500 @enderror" 
                                   value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('Y-m-d\TH:i')) }}" required>
                        </div>
                        @error('end_time') <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Status Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Trạng thái buổi tập</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative group cursor-pointer">
                            <input type="radio" name="status" value="upcoming" class="peer sr-only" {{ $schedule->status == 'upcoming' ? 'checked' : '' }}>
                            <div class="px-4 py-3 bg-slate-50 border border-slate-100 text-slate-600 rounded-2xl text-center text-xs font-bold uppercase tracking-widest peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-600 transition-all hover:bg-slate-100">
                                Sắp diễn ra
                            </div>
                        </label>
                        <label class="relative group cursor-pointer">
                            <input type="radio" name="status" value="completed" class="peer sr-only" {{ $schedule->status == 'completed' ? 'checked' : '' }}>
                            <div class="px-4 py-3 bg-slate-50 border border-slate-100 text-slate-600 rounded-2xl text-center text-xs font-bold uppercase tracking-widest peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-600 transition-all hover:bg-slate-100">
                                Đã kết thúc
                            </div>
                        </label>
                        <label class="relative group cursor-pointer">
                            <input type="radio" name="status" value="cancelled" class="peer sr-only" {{ $schedule->status == 'cancelled' ? 'checked' : '' }}>
                            <div class="px-4 py-3 bg-slate-50 border border-slate-100 text-slate-600 rounded-2xl text-center text-xs font-bold uppercase tracking-widest peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-600 transition-all hover:bg-slate-100">
                                Hủy buổi tập
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Room Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Phòng học / Ghi chú địa điểm</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-orange-600 transition-colors">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <input type="text" name="room" 
                               class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-orange-600/5 focus:border-orange-600 focus:bg-white transition-all outline-none font-medium" 
                               placeholder="VD: Phòng Yoga A1, Khu Boxing..." value="{{ old('room', $schedule->room) }}">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-50 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.schedules.index') }}" class="px-8 py-3.5 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">
                        HUỶ THAY ĐỔI
                    </a>
                    <button type="submit" class="px-10 py-3.5 bg-blue-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-blue-600/20 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all">
                        CẬP NHẬT LỊCH
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
