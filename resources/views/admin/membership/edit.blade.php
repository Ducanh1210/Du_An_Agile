@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Chỉnh sửa gói tập')

@section('content')
<div class="max-w-4xl mx-auto leading-relaxed  uppercase tracking-widest leading-normal tracking-tighter">
    <!-- Breadcrumb Link Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.memberships.index') }}" class="text-sm font-bold text-slate-400 hover:text-primary transition-colors flex items-center gap-2">
            <i class="fa-solid fa-arrow-left-long"></i> Quay lại Danh sách
        </a>
        <div class="text-[10px] font-bold text-slate-300 uppercase tracking-widest leading-loose italic">Mã Gói: #{{ $memDetail->id }}</div>
    </div>

    <!-- Main Edit Form Card -->
    <form action="{{ route('admin.memberships.update', $memDetail->id) }}" method="POST" class="space-y-8 animate-fade-in-up">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-10 leading-relaxed group hover:shadow-xl transition-all duration-500">
            <div class="flex items-center gap-4 mb-10 pb-6 border-b border-gray-50 leading-relaxed uppercase tracking-tighter ">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight leading-normal">Cập nhật Nội dung Gói tập</h2>
                    <p class="text-sm text-slate-400 font-medium">Thay đổi thông tin cho gói <strong>{{ $memDetail->name }}</strong>.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10 leading-normal">
                <!-- Tên gói tập -->
                <div class="md:col-span-2 relative group-form leading-relaxed  uppercase tracking-widest leading-normal ">
                    <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500 leading-relaxed uppercase tracking-widest ">Tên gọi Gói Fitness <span class="text-red-500">*</span></label>
                    <div class="relative leading-relaxed ">
                        <i class="fa-solid fa-pen-nib absolute left-5 top-4 text-slate-300"></i>
                        <input type="text" name="name" id="name" value="{{ old('name', $memDetail->name) }}"
                            class="w-full pl-12 pr-6 py-4 rounded-2xl border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all duration-300  leading-normal uppercase tracking-widest">
                    </div>
                </div>

                <!-- Loại gói tập -->
                <div class="relative group-form leading-relaxed  uppercase tracking-widest leading-normal ">
                    <label for="category" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500">Chuyên mục <span class="text-red-500">*</span></label>
                    <div class="relative ">
                        <i class="fa-solid fa-list-ul absolute left-5 top-4 text-slate-300 leading-normal "></i>
                        <select name="category" id="category" class="w-full pl-12 pr-6 py-4 rounded-2xl border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all duration-300 appearance-none ">
                            <option value="gym" {{ old('category', $memDetail->category) == 'gym' ? 'selected' : '' }}>GYM / FITNESS</option>
                            <option value="yoga" {{ old('category', $memDetail->category) == 'yoga' ? 'selected' : '' }}>YOGA / THERAPY</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-5 top-4.5 text-[10px] text-slate-400 leading-normal "></i>
                    </div>
                </div>

                <!-- Thời hạn -->
                <div class="relative group-form leading-relaxed  uppercase tracking-widest leading-normal ">
                    <label for="duration_days" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500 leading-relaxed uppercase tracking-widest ">Hiệu lực (Ngày) <span class="text-red-500">*</span></label>
                    <div class="relative leading-relaxed ">
                        <i class="fa-regular fa-calendar-check absolute left-5 top-4 text-slate-300 leading-normal "></i>
                        <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', $memDetail->duration_days) }}" 
                            class="w-full pl-12 pr-12 py-4 rounded-2xl border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all duration-300  leading-normal uppercase tracking-widest">
                        <span class="absolute right-5 top-4 text-xs font-bold text-slate-400 uppercase tracking-tighter leading-relaxed uppercase tracking-widest ">Ngày</span>
                    </div>
                </div>

                <!-- Giá tiền -->
                <div class="relative group-form leading-relaxed  uppercase tracking-widest leading-normal ">
                    <label for="price" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500 leading-relaxed uppercase tracking-widest  whitespace-nowrap">Đơn giá niêm yết <span class="text-red-500">*</span></label>
                    <div class="relative leading-relaxed ">
                        <i class="fa-solid fa-money-bill-wave absolute left-5 top-4 text-slate-300 leading-normal "></i>
                        <input type="number" name="price" id="price" value="{{ old('price', (int)$memDetail->price) }}"
                            class="w-full pl-12 pr-16 py-4 rounded-2xl border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all duration-300  leading-normal uppercase tracking-widest">
                        <span class="absolute right-5 top-4 text-xs font-bold text-slate-900 tracking-tight leading-normal uppercase ">VND</span>
                    </div>
                </div>

                <!-- Trạng thái -->
                <div class="relative group-form leading-relaxed  uppercase tracking-widest leading-normal ">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500 leading-relaxed uppercase tracking-widest ">Trạng thái phát hành</label>
                    <div class="flex items-center gap-4 mt-2 ">
                        <label class="cursor-pointer group-check ">
                            <input type="radio" name="is_active" value="1" {{ old('is_active', $memDetail->is_active) == 1 ? 'checked' : '' }} class="hidden peer leading-normal">
                            <div class="px-6 py-3 rounded-xl bg-slate-50 text-slate-400 peer-checked:bg-emerald-500 peer-checked:text-white transition-all font-bold text-xs uppercase tracking-widest border border-transparent peer-checked:shadow-lg peer-checked:shadow-emerald-500/30 leading-normal ">
                                Đang hoạt động
                            </div>
                        </label>
                        <label class="cursor-pointer group-check leading-normal ">
                            <input type="radio" name="is_active" value="0" {{ old('is_active', $memDetail->is_active) == 0 ? 'checked' : '' }} class="hidden peer leading-normal">
                            <div class="px-6 py-3 rounded-xl bg-slate-50 text-slate-400 peer-checked:bg-red-500 peer-checked:text-white transition-all font-bold text-xs uppercase tracking-widest border border-transparent peer-checked:shadow-lg peer-checked:shadow-red-500/30 leading-normal ">
                                Dừng cung cấp
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Huấn luyện viên -->
                <div class="relative group-form leading-relaxed  uppercase tracking-widest leading-normal ">
                    <label for="allow_pt" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500 leading-relaxed uppercase tracking-widest ">Huấn luyện viên (PT)</label>
                    <div class="relative  leading-normal">
                        <i class="fa-solid fa-user-ninja absolute left-5 top-4 text-slate-300 leading-normal "></i>
                        <select name="allow_pt" id="allow_pt" onchange="togglePT()" class="w-full pl-12 pr-6 py-4 rounded-2xl border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all duration-300 appearance-none  leading-normal">
                            <option value="0" {{ old('allow_pt', $memDetail->allow_pt) == '0' ? 'selected' : '' }}>Không sử dụng PT</option>
                            <option value="1" {{ old('allow_pt', $memDetail->allow_pt) == '1' ? 'selected' : '' }}>Có dán nhãn PT</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-5 top-4.5 text-[10px] text-slate-400 leading-normal "></i>
                    </div>
                </div>

                <!-- Số buổi PT -->
                <div id="pt_sessions_container" class="relative group-form leading-relaxed transition-all duration-300 {{ old('allow_pt', $memDetail->allow_pt) == '1' ? 'scale-100 opacity-100' : 'scale-95 opacity-0 hidden' }}">
                    <label for="pt_sessions" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-blue-600 leading-relaxed uppercase tracking-widest underlined">Số buổi tối đa <span class="text-red-500">*</span></label>
                    <div class="relative leading-relaxed ">
                        <i class="fa-solid fa-chalkboard-user absolute left-5 top-4 text-blue-400 leading-normal "></i>
                        <input type="number" name="pt_sessions" id="pt_sessions" value="{{ old('pt_sessions', $memDetail->pt_sessions) }}"
                            class="w-full pl-12 pr-12 py-4 rounded-2xl border-none bg-blue-50/30 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all duration-300 ring-1 ring-blue-100 leading-normal ">
                        <span class="absolute right-5 top-4 text-xs font-bold text-blue-400 uppercase tracking-tighter leading-relaxed uppercase tracking-widest ">Buổi</span>
                    </div>
                </div>

                <!-- Mô tả -->
                <div class="md:col-span-2 relative group-form leading-relaxed  uppercase tracking-widest leading-normal ">
                    <label for="description" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500 leading-relaxed uppercase tracking-widest underlined whitespace-nowrap">Mô tả đặc quyền</label>
                    <div class="relative leading-relaxed ">
                        <textarea name="description" id="description" rows="4"
                            class="w-full p-6 pt-10 rounded-[32px] border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 outline-none transition-all duration-300 resize-none min-h-[140px] leading-normal ">{{ old('description', $memDetail->description) }}</textarea>
                        <i class="fa-solid fa-quote-left absolute left-6 top-4 text-slate-300 text-sm leading-normal "></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons Bar -->
        <div class="flex items-center justify-center md:justify-end gap-4 transform translate-y-[-24px]  uppercase tracking-widest leading-relaxed">
            <button type="reset" class="px-8 py-3 rounded-2xl font-bold text-sm text-slate-400 hover:bg-white hover:text-slate-600 transition-all border border-transparent hover:border-gray-100 leading-normal ">
                Phục hồi dữ liệu gốc
            </button>
            <button type="submit" class="px-12 py-4 bg-blue-600 text-white rounded-2xl font-bold text-[15px] shadow-2xl shadow-blue-600/20 hover:bg-blue-700 hover:scale-105 active:scale-95 transition-all leading-normal ">
                <i class="fa-solid fa-floppy-disk mr-2.5 leading-normal "></i> Lưu thay đổi ngay
            </button>
        </div>
    </form>
</div>

<script>
    function togglePT() {
        const allowPT = document.getElementById('allow_pt').value;
        const container = document.getElementById('pt_sessions_container');
        if (allowPT == '1') {
            container.classList.remove('hidden');
            setTimeout(() => {
                container.classList.remove('opacity-0', 'scale-95');
                container.classList.add('opacity-100', 'scale-100');
            }, 10);
        } else {
            container.classList.remove('opacity-100', 'scale-100');
            container.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                container.classList.add('hidden');
            }, 300);
        }
    }
</script>
@endsection

