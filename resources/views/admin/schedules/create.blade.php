@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Tạo lịch mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center text-sm font-bold text-slate-400 hover:text-orange-600 transition-colors mb-6 group">
        <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
        QUAY LẠI DANH SÁCH
    </a>

    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 bg-slate-50/50">
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Thiết lập lịch học mới</h2>
            <p class="text-sm text-slate-400 font-medium uppercase tracking-tighter">Nhập thông tin chi tiết cho buổi huấn luyện hoặc lớp học.</p>
        </div>

        <div class="p-8">
            <form action="{{ route('admin.schedules.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Title Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2.5 ml-1">Tiêu đề buổi tập / Tên lớp</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-orange-600 transition-colors">
                            <i class="fa-solid fa-heading"></i>
                        </div>
                        <input type="text" name="title" 
                               class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-orange-600/5 focus:border-orange-600 focus:bg-white transition-all outline-none font-medium @error('title') border-red-500 @enderror" 
                               placeholder="VD: Yoga Flow, Boxing PT, Cardio..." value="{{ old('title') }}">
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
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 text-slate-900 text-sm rounded-2xl focus:ring-4 focus:ring-orange-600/5 focus:border-orange-600 focus:bg-white transition-all outline-none font-medium appearance-none @error('trainer_id') border-red-500 @enderror">
                            <option value="">-- Chọn Huấn luyện viên --</option>
                            @foreach($trainers as $trainer)
                                <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                    {{ $trainer->name }} ({{ $trainer->specialization }})
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
                                   value="{{ old('start_time') }}">
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
                                   value="{{ old('end_time') }}">
                        </div>
                        @error('end_time') <p class="mt-2 text-xs font-bold text-red-500 ml-1">{{ $message }}</p> @enderror
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
                               placeholder="VD: Phòng Yoga A1, Khu Boxing..." value="{{ old('room') }}">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-50 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.schedules.index') }}" class="px-8 py-3.5 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors">
                        HỦY BỎ
                    </a>
                    <button type="submit" class="px-10 py-3.5 bg-orange-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-orange-600/20 hover:bg-orange-700 hover:scale-[1.02] active:scale-95 transition-all">
                        LƯU LỊCH HỌC
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

