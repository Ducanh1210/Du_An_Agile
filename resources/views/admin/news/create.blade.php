@extends(auth()->user()->role === 'staff' ? 'layouts.staff' : 'layouts.admin')

@section('title', 'Thêm Tin tức mới')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Back link --}}
    <a href="{{ route('admin.news.index') }}"
       class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-orange-600 font-semibold mb-6 transition-colors">
        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
    </a>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content Column --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Content Block --}}
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-slate-50/50">
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight">Nội dung bài viết</h2>
                        <p class="text-sm text-slate-400 mt-0.5">Soạn thảo nội dung chính của tin tức</p>
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
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tiêu đề <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                   placeholder="Nhập tiêu đề bài viết..."
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 text-white">Font tiêu đề</label>
                                <select name="title_font_family" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all bg-white">
                                    <option value="Outfit" {{ old('title_font_family') == 'Outfit' ? 'selected' : '' }}>Outfit (Mặc định)</option>
                                    <option value="Inter" {{ old('title_font_family') == 'Inter' ? 'selected' : '' }}>Inter</option>
                                    <option value="Roboto" {{ old('title_font_family') == 'Roboto' ? 'selected' : '' }}>Roboto</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Cỡ chữ (px)</label>
                                <input type="number" name="title_font_size" value="{{ old('title_font_size', 24) }}"
                                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Mô tả ngắn</label>
                            <textarea name="excerpt" rows="3" placeholder="Tóm tắt ngắn gọn..."
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all resize-none italic">{{ old('excerpt') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nội dung chi tiết <span class="text-red-500">*</span></label>
                            <textarea name="content" rows="15" required
                                      placeholder="Nội dung chính..."
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all resize-y">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SEO Block --}}
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 flex items-center gap-2 bg-slate-50/50">
                        <i class="fa-solid fa-search text-orange-500"></i>
                        <h2 class="font-bold text-slate-900 tracking-tight text-xl">Tối ưu SEO</h2>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                                   placeholder="Tiêu đề hiển thị trên Google..."
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Meta Description</label>
                            <textarea name="meta_description" rows="3" placeholder="Mô tả hiển thị trên Google..."
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all resize-none">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Column --}}
            <div class="lg:col-span-1 space-y-8">
                {{-- Publish Block --}}
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane text-orange-500"></i>
                        <h2 class="font-bold text-slate-900 tracking-tight">Xuất bản</h2>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Trạng thái</label>
                            <select name="news_status" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all bg-white">
                                <option value="draft" {{ old('news_status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                <option value="pending" {{ old('news_status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                                <option value="published" {{ old('news_status') == 'published' ? 'selected' : '' }}>Công khai</option>
                                <option value="hidden" {{ old('news_status') == 'hidden' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" id="featuredToggle"
                                       class="sr-only peer" {{ old('is_featured') ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                            </label>
                            <div>
                                <div class="text-sm font-bold text-slate-700">Nổi bật</div>
                                <div class="text-[10px] text-slate-400 leading-none">Ưu tiên hiển thị trang chủ</div>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full py-4 bg-orange-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-orange-600/20 hover:bg-orange-700 hover:scale-[1.02] active:scale-95 transition-all">
                            <i class="fa-solid fa-floppy-disk mr-2"></i> Lưu bài viết
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
                            <label class="block text-sm font-bold text-slate-700 mb-2">Danh mục</label>
                            <select name="category_id"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all bg-white">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Thẻ (Tags)</label>
                            <div class="flex flex-wrap gap-2 max-h-40 overflow-y-auto p-3 border border-gray-100 rounded-xl bg-slate-50/50">
                                @foreach($tags as $tag)
                                <label class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 rounded-lg cursor-pointer hover:border-orange-500 hover:bg-orange-50 transition-all">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                           class="w-4 h-4 rounded text-orange-600 focus:ring-orange-500 border-gray-300"
                                           {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                                    <span class="text-xs font-bold text-slate-600">#{{ $tag->name }}</span>
                                </label>
                                @endforeach
                            </div>
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
                            <label for="newsImageInput" class="block w-full aspect-video rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center cursor-pointer hover:border-orange-300 hover:bg-orange-50/30 transition-all overflow-hidden group">
                                <img id="imagePreview" class="absolute inset-0 w-full h-full object-cover hidden">
                                <div id="uploadPlaceholder" class="flex flex-col items-center gap-2 text-slate-400 group-hover:text-orange-500 transition-colors">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl"></i>
                                    <span class="text-xs font-bold">Tải lên ảnh thumbnail</span>
                                </div>
                            </label>
                            <input type="file" name="image" accept="image/*" id="newsImageInput" class="hidden">
                        </div>
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

