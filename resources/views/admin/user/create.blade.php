@extends('layouts.admin')

@section('title', 'Thêm người dùng mới')

@section('content')
<div class="max-w-5xl mx-auto pb-12">
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header Section -->
        <div class="px-8 py-8 border-b border-gray-50 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase">Thêm tài khoản hệ thống</h2>
                <p class="text-sm text-slate-400 font-bold tracking-tighter uppercase">Điền thông tin để tạo người dùng mới cho EXTRA FIT+.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="group flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-xl font-bold text-xs hover:border-blue-500 hover:text-blue-600 transition-all duration-300 uppercase tracking-widest tracking-tighter shadow-sm">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Quay lại
            </a>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-12">
            @csrf
            
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Left Column: Avatar Upload & Preview -->
                <div class="w-full lg:w-1/3 flex flex-col items-center">
                    <div class="space-y-6 text-center w-full">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-[.2em] mb-4">Ảnh đại diện</label>
                        
                        <div class="relative group mx-auto">
                            <div id="avatarPreview" class="w-48 h-48 rounded-[40px] bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden transition-all duration-300 group-hover:border-blue-300 group-hover:shadow-xl shadow-blue-600/5">
                                <i class="fa-solid fa-user-astronaut text-5xl text-slate-300 group-hover:scale-110 transition-transform duration-500"></i>
                                <img id="previewImg" class="w-full h-full object-cover hidden" alt="Avatar Preview">
                            </div>
                            
                            <!-- Success/Selection Badge -->
                            <div id="checkBadge" class="absolute -bottom-2 -right-2 w-10 h-10 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg transform scale-0 transition-transform duration-300 border-4 border-white">
                                <i class="fa-solid fa-check text-sm"></i>
                            </div>

                            <!-- Click to upload overlay -->
                            <label for="avatarInput" class="absolute inset-0 cursor-pointer flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-[40px]">
                                <span class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl text-white text-[10px] font-black uppercase tracking-widest border border-white/30">Chọn tệp</span>
                            </label>
                        </div>

                        <div class="space-y-3">
                            <input type="file" name="avatar_url" id="avatarInput" accept="image/*" class="hidden">
                            <div id="fileName" class="text-[10px] text-slate-400 font-bold uppercase tracking-tight italic">
                                Chưa có tệp nào được chọn
                            </div>
                            @error('avatar_url') <span class="block text-[11px] font-bold text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Right Column: Form Fields -->
                <div class="flex-1 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Name -->
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-slate-900 uppercase tracking-[.2em] ml-1">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" name="name" 
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none"
                                placeholder="Nguyễn Văn A" value="{{ old('name') }}">
                            @error('name') <span class="text-[11px] font-bold text-red-500 ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-slate-900 uppercase tracking-[.2em] ml-1">Địa chỉ Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" 
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none"
                                placeholder="name@example.com" value="{{ old('email') }}">
                            @error('email') <span class="text-[11px] font-bold text-red-500 ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        <!-- Role Selection -->
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-slate-900 uppercase tracking-[.2em] ml-1">Vai trò hệ thống <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <select name="role" 
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Khách hàng (User)</option>
                                    <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>Huấn luyện viên (Trainer)</option>
                                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Nhân viên (Staff)</option>
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-hover:text-blue-500 transition-colors">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight ml-1 italic">
                                Lưu ý: Chỉ có duy nhất 1 Quản trị viên cao nhất.
                            </p>
                            @error('role') <span class="text-[11px] font-bold text-red-500 ml-1 italic">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="space-y-3">
                            <label class="block text-xs font-black text-slate-900 uppercase tracking-[.2em] ml-1">Mật khẩu ban đầu <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="password" id="passwordInput"
                                    class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword()" class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-500 transition-colors">
                                    <i id="eyeIcon" class="fa-solid fa-eye text-sm"></i>
                                </button>
                            </div>
                            @error('password') <span class="text-[11px] font-bold text-red-500 ml-1 italic">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-10 flex flex-col sm:flex-row items-center justify-end gap-4">
                        <button type="reset" class="w-full sm:w-auto px-10 py-4 bg-slate-100 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 active:scale-95 transition-all">
                            Làm mới
                        </button>
                        <button type="submit" class="w-full sm:w-auto px-12 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-[.2em] shadow-xl shadow-blue-600/30 hover:bg-blue-700 hover:-translate-y-1 active:scale-95 transition-all">
                            Xác nhận thêm mới <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const avatarInput = document.getElementById('avatarInput');
    const previewImg = document.getElementById('previewImg');
    const avatarPreview = document.getElementById('avatarPreview');
    const checkBadge = document.getElementById('checkBadge');
    const defaultIcon = avatarPreview.querySelector('i');
    const fileNameDisplay = document.getElementById('fileName');

    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileNameDisplay.textContent = file.name;
            const reader = new FileReader();
            reader.onload = function(event) {
                previewImg.src = event.target.result;
                previewImg.classList.remove('hidden');
                defaultIcon.classList.add('hidden');
                avatarPreview.classList.add('border-blue-500', 'ring-4', 'ring-blue-500/10');
                checkBadge.classList.replace('scale-0', 'scale-100');
            };
            reader.readAsDataURL(file);
        } else {
            fileNameDisplay.textContent = 'Chưa có tệp nào được chọn';
            previewImg.classList.add('hidden');
            defaultIcon.classList.remove('hidden');
            avatarPreview.classList.remove('border-blue-500', 'ring-4', 'ring-blue-500/10');
            checkBadge.classList.replace('scale-100', 'scale-0');
        }
    });

    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection
