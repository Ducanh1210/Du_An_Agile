@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Chỉnh sửa Tin tức')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Back link --}}
    <a href="{{ route('admin.news.index') }}"
       class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-orange-600 font-semibold mb-6 transition-colors">
        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
    </a>

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content Column --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Content Block --}}
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden shadow-orange-500/5">
                    <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-slate-50/50">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Chỉnh sửa nội dung</h2>
                            <p class="text-sm text-slate-400 mt-0.5 font-mono">ID: #{{ $news->id }}</p>
                        </div>
                    </div>

                    <div class="p-8 space-y-6">
                        @if($errors->any())
                        <div class="px-5 py-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 font-mono uppercase tracking-wider">Tiêu đề <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $news->title) }}" 
                                   placeholder="Nhập tiêu đề bài viết..."
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all font-bold text-slate-800">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Font tiêu đề</label>
                                <select name="title_font_family" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all bg-white font-medium">
                                    <option value="Outfit" {{ old('title_font_family', $news->title_font_family) == 'Outfit' ? 'selected' : '' }}>Outfit (Mặc định)</option>
                                    <option value="Inter" {{ old('title_font_family', $news->title_font_family) == 'Inter' ? 'selected' : '' }}>Inter</option>
                                    <option value="Roboto" {{ old('title_font_family', $news->title_font_family) == 'Roboto' ? 'selected' : '' }}>Roboto</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Cỡ chữ (px)</label>
                                <input type="number" name="title_font_size" value="{{ old('title_font_size', $news->title_font_size ?? 24) }}"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all font-medium">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 font-mono uppercase tracking-wider">Mô tả ngắn</label>
                            <textarea name="excerpt" rows="3" placeholder="Tóm tắt ngắn gọn..."
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all resize-none italic text-slate-600">{{ old('excerpt', $news->excerpt) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 font-mono uppercase tracking-wider">Nội dung chi tiết <span class="text-red-500">*</span></label>
                            <textarea name="content" rows="15"
                                      placeholder="Nội dung chính..."
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all resize-y leading-relaxed">{{ old('content', $news->content) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SEO Block --}}
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 flex items-center gap-2 bg-slate-50/50">
                        <i class="fa-solid fa-search text-orange-500"></i>
                        <h2 class="font-bold text-slate-900 tracking-tight text-xl">Tối ưu SEO Search Console</h2>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title', $news->meta_title) }}"
                                   placeholder="Tiêu đề hiển thị trên Google..."
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all">
                            <p class="text-[10px] text-slate-400 mt-1 font-mono italic">Khuyên dùng: 50-60 ký tự</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Meta Description</label>
                            <textarea name="meta_description" rows="3" placeholder="Mô tả hiển thị trên Google..."
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all resize-none">{{ old('meta_description', $news->meta_description) }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-1 font-mono italic">Khuyên dùng: 150-160 ký tự</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Column --}}
            <div class="lg:col-span-1 space-y-8">
                {{-- Publish Block --}}
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden border-t-8 border-t-orange-500/10">
                    <div class="px-8 py-6 border-b border-gray-50 flex items-center gap-2 bg-orange-50/20">
                        <i class="fa-solid fa-cloud-arrow-up text-orange-500"></i>
                        <h2 class="font-bold text-slate-900 tracking-tight">Cập nhật ngay</h2>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Trạng thái hiện tại</label>
                            <select name="news_status" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all bg-white font-bold text-slate-700">
                                <option value="draft" {{ old('news_status', $news->news_status) == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                <option value="pending" {{ old('news_status', $news->news_status) == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                                <option value="published" {{ old('news_status', $news->news_status) == 'published' ? 'selected' : '' }}>Công khai</option>
                                <option value="hidden" {{ old('news_status', $news->news_status) == 'hidden' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-3 p-4 bg-orange-50/30 rounded-2xl border border-orange-100/50">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" id="featuredToggle"
                                       class="sr-only peer" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                            </label>
                            <div>
                                <div class="text-sm font-bold text-slate-700 tracking-tight">Highlight nổi bật</div>
                                <div class="text-[10px] text-slate-400 leading-none italic">Đẩy lên top tiêu điểm</div>
                            </div>
                        </div>

                        <div class="text-xs text-slate-400 p-2 text-center border-t border-slate-50 mt-2">
                           <i class="fa-solid fa-calendar-day mr-1"></i> Đăng: {{ $news->published_at ? $news->published_at->format('d/m/Y H:i') : 'N/A' }}
                        </div>

                        <button type="submit"
                                class="w-full py-4 bg-orange-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-orange-600/30 hover:bg-orange-700 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-save"></i> Cập nhật bài viết
                        </button>
                    </div>
                </div>

                {{-- Category & Tags --}}
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 flex items-center gap-2">
                        <i class="fa-solid fa-folder-tree text-orange-500"></i>
                        <h2 class="font-bold text-slate-900 tracking-tight">Phân loại</h2>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Danh mục chính</label>
                            <select name="category_id"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all bg-white font-medium">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $news->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 font-mono uppercase tracking-wider text-[11px]">Thẻ (Tags)</label>
                            <input type="text" name="tags_list" value="{{ old('tags_list', $news->tags_list) }}"
                                   placeholder="Ví dụ: sức khỏe, tập gym, giảm cân"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all">
                            <p class="text-[10px] text-slate-400 mt-2">Nhập các thẻ cách nhau bởi dấu phẩy (,)</p>
                        </div>
                    </div>
                </div>

                {{-- Image --}}
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 flex items-center gap-2">
                        <i class="fa-solid fa-image text-orange-500"></i>
                        <h2 class="font-bold text-slate-900 tracking-tight">Ảnh đại diện</h2>
                    </div>
                    <div class="p-8 space-y-4">
                        <div class="relative group">
                            <label for="newsImageInput" class="block w-full aspect-video rounded-3xl border-2 border-dashed border-gray-100 flex flex-col items-center justify-center cursor-pointer hover:border-orange-500 hover:bg-orange-50/30 transition-all overflow-hidden group">
                                @if($news->image)
                                <img id="imagePreview" src="{{ asset('storage/' . $news->image) }}" class="absolute inset-0 w-full h-full object-cover group-hover:opacity-75 transition-opacity">
                                @else
                                <img id="imagePreview" class="absolute inset-0 w-full h-full object-cover hidden group-hover:opacity-75 transition-opacity">
                                @endif
                                <div id="uploadPlaceholder" class="flex flex-col items-center gap-2 text-slate-300 group-hover:text-orange-600 transition-colors z-10 bg-white/20 backdrop-blur-sm p-4 rounded-full">
                                    <i class="fa-solid fa-camera-rotate text-3xl"></i>
                                    <span class="text-xs font-bold font-mono">Thay đổi Cover</span>
                                </div>
                            </label>
                            <input type="file" name="image" accept="image/*" id="newsImageInput" class="hidden">
                        </div>
                        <p class="text-[10px] text-center text-slate-400 italic font-medium tracking-tight uppercase">Min-size: 1200x630 (Tỉ lệ 1.91:1)</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('newsImageInput')?.addEventListener('change', function(e) {
    const reader = new FileReader();
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    
    reader.onload = e => { 
        preview.src = e.target.result; 
        preview.classList.remove('hidden'); 
        placeholder.classList.add('hidden');
    };
    if (this.files[0]) reader.readAsDataURL(this.files[0]);
});
</script>
@endpush
@endsection

