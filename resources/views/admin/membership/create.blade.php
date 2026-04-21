@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Tạo gói tập mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb Link Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.memberships.index') }}" class="text-sm font-bold text-slate-400 hover:text-primary transition-colors flex items-center gap-2">
            <i class="fa-solid fa-arrow-left-long"></i> Quay lại Danh sách
        </a>
        <div class="text-[10px] font-bold text-slate-300 uppercase tracking-widest leading-loose italic">Bước 1: Thiết lập cơ bản</div>
    </div>

    <!-- Main Creation Form Card -->
    <form action="{{ route('admin.memberships.store') }}" method="POST" class="space-y-8 animate-fade-in-up">
        @csrf
        
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-10 leading-relaxed group hover:shadow-xl transition-all duration-500">
            <div class="flex items-center gap-4 mb-10 pb-6 border-b border-gray-50 leading-relaxed uppercase tracking-tighter">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight leading-normal">Ký gửi Dịch vụ Mới</h2>
                    <p class="text-sm text-slate-400 font-medium">Cung cấp các thông tin chi tiết để niêm yết lên hệ thống khách hàng.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                <!-- Tên gói tập -->
                <div class="md:col-span-2 relative group-form leading-relaxed">
                    <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1">Tên gọi Gói Fitness <span class="text-red-500">*</span></label>
                    <div class="relative leading-relaxed">
                        <i class="fa-solid fa-pen-nib absolute left-5 top-4 text-slate-300"></i>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="VD: GYM SUPERIOR 3 THÁNG"
                            class="w-full pl-12 pr-6 py-4 rounded-2xl border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300 @error('name') ring-2 ring-red-500/20 bg-red-50 @enderror leading-normal tracking-tighter ">
                    </div>
                    @error('name') <p class="mt-2 text-xs text-red-500 font-semibold italic ml-2 leading-relaxed uppercase tracking-widest ">{{ $message }}</p> @enderror
                </div>

                <!-- Loại gói tập -->
                <div class="relative group-form leading-relaxed tracking-widest uppercase tracking-tighter ">
                    <label for="category" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500">Chuyên mục <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-list-ul absolute left-5 top-4 text-slate-300 leading-normal"></i>
                        <select name="category" id="category" class="w-full pl-12 pr-6 py-4 rounded-2xl border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300 appearance-none ">
                            <option value="gym" {{ old('category') == 'gym' ? 'selected' : '' }}>GYM / FITNESS</option>
                            <option value="yoga" {{ old('category') == 'yoga' ? 'selected' : '' }}>YOGA / THERAPY</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-5 top-4.5 text-[10px] text-slate-400"></i>
                    </div>
                </div>

                <!-- Thời hạn -->
                <div class="relative group-form leading-relaxed tracking-widest uppercase tracking-tighter ">
                    <label for="duration_days" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500 leading-relaxed uppercase tracking-tighter">Hiệu lực (Ngày) <span class="text-red-500">*</span></label>
                    <div class="relative leading-relaxed ">
                        <i class="fa-regular fa-calendar-check absolute left-5 top-4 text-slate-300"></i>
                        <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', 30) }}" 
                            class="w-full pl-12 pr-12 py-4 rounded-2xl border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300 leading-relaxed uppercase tracking-tighter ">
                        <span class="absolute right-5 top-4 text-xs font-bold text-slate-400 uppercase tracking-tighter leading-relaxed uppercase tracking-widest">Ngày</span>
                    </div>
                </div>

                <!-- Giá tiền -->
                <div class="relative group-form leading-relaxed tracking-widest uppercase tracking-tighter ">
                    <label for="price" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500 leading-relaxed uppercase tracking-widest underlined whitespace-nowrap">Đơn giá niêm yết <span class="text-red-500">*</span></label>
                    <div class="relative leading-relaxed ">
                        <i class="fa-solid fa-money-bill-wave absolute left-5 top-4 text-slate-300"></i>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="0"
                            class="w-full pl-12 pr-16 py-4 rounded-2xl border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300 leading-relaxed uppercase tracking-tighter ">
                        <span class="absolute right-5 top-4 text-xs font-bold text-slate-900 tracking-tight leading-normal uppercase ">VND</span>
                    </div>
                </div>

                <!-- Huấn luyện viên -->
                <div class="relative group-form leading-relaxed tracking-widest uppercase tracking-tighter ">
                    <label for="allow_pt" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500 leading-normal uppercase tracking-widest ">Kèm huấn luyện (PT)</label>
                    <div class="relative ">
                        <i class="fa-solid fa-user-ninja absolute left-5 top-4 text-slate-300"></i>
                        <select name="allow_pt" id="allow_pt" onchange="togglePT()" class="w-full pl-12 pr-6 py-4 rounded-2xl border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300 appearance-none ">
                            <option value="0" {{ old('allow_pt') == '0' ? 'selected' : '' }}>Không sử dụng PT</option>
                            <option value="1" {{ old('allow_pt') == '1' ? 'selected' : '' }}>Có dán nhãn PT hướng dẫn</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-5 top-4.5 text-[10px] text-slate-400"></i>
                    </div>
                </div>

                <!-- Số buổi PT -->
                <div id="pt_sessions_container" class="relative group-form leading-relaxed transition-all duration-300 {{ old('allow_pt') == '1' ? 'scale-100 opacity-100' : 'scale-95 opacity-0 hidden' }}">
                    <label for="pt_sessions" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-orange-600 leading-relaxed uppercase tracking-widest underlined">Số buổi hướng dẫn <span class="text-red-500">*</span></label>
                    <div class="relative ">
                        <i class="fa-solid fa-chalkboard-user absolute left-5 top-4 text-orange-400 leading-relaxed"></i>
                        <input type="number" name="pt_sessions" id="pt_sessions" value="{{ old('pt_sessions', 0) }}"
                            class="w-full pl-12 pr-12 py-4 rounded-2xl border-none bg-orange-50/30 focus:bg-white focus:ring-4 focus:ring-orange-500/10 outline-none transition-all duration-300 ring-1 ring-orange-100  leading-normal">
                        <span class="absolute right-5 top-4 text-xs font-bold text-orange-400 uppercase tracking-tighter ">Buổi</span>
                    </div>
                </div>

                <!-- Mô tả -->
                <div class="md:col-span-2 relative group-form leading-normal uppercase tracking-widest ">
                    <label for="description" class="block text-xs font-bold text-slate-400 uppercase tracking-[.15em] mb-3 ml-1 text-slate-500 leading-normal uppercase tracking-widest underlined">Lợi ích & Mô tả dịch vụ</label>
                    <div class="relative leading-relaxed ">
                        <textarea name="description" id="description" rows="4" placeholder="VD: Bao gồm tủ đồ riêng, nước uống miễn phí tại quầy..."
                            class="w-full p-6 pt-10 rounded-[32px] border-none bg-slate-50 focus:bg-white focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300 resize-none min-h-[140px]  leading-normal">{{ old('description') }}</textarea>
                        <i class="fa-solid fa-quote-left absolute left-6 top-4 text-slate-300 text-sm leading-normal "></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons Bar -->
        <div class="flex items-center justify-center md:justify-end gap-4 transform translate-y-[-24px]">
            <button type="reset" class="px-8 py-3 rounded-2xl font-bold text-sm text-slate-400 hover:bg-white hover:text-slate-600 transition-all border border-transparent hover:border-gray-100  uppercase tracking-widest leading-relaxed">
                Xóa làm lại
            </button>
            <button type="submit" class="px-12 py-4 bg-slate-900 text-white rounded-2xl font-bold text-[15px] shadow-2xl shadow-slate-900/20 hover:bg-slate-800 hover:scale-105 active:scale-95 transition-all  uppercase tracking-widest leading-relaxed tracking-tighter">
                <i class="fa-solid fa-rocket mr-2.5 text-orange-500"></i> Xuất bản Gói tập
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
                document.getElementById('pt_sessions').value = 0;
            }, 300);
        }
    }
</script>
@endsection

