@extends('layouts.client')

@section('title', 'Tin tức & Sự kiện - EXTRA FIT+ GYM')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endsection

@section('content')
{{-- --- News Hero --- --}}
<section class="news-hero">
    <div class="container text-center">
        <div class="news-hero-content animate-on-scroll">
            <span class="section-tag">Thế giới thể hình</span>
            <h1 class="news-hero-title">TIN TỨC <span>&</span> SỰ KIỆN</h1>
            <p class="news-hero-subtitle">
                Cập nhật những kiến thức tập luyện mới nhất, chế độ dinh dưỡng khoa học 
                và những ưu đãi độc quyền chỉ có tại EXTRA FIT+.
            </p>
        </div>
    </div>
</section>

{{-- --- Main Content --- --}}
<section class="news-container bg-light-soft">
    <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- Left: News Feed --}}
            <div class="lg:col-span-8">
                <div class="news-grid">
                    @forelse($news as $post)
                    <article class="news-card animate-on-scroll">
                        <div class="news-card-img-wrap">
                            <a href="{{ route('news.detail', $post->slug) }}">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="news-card-img">
                                @else
                                    <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                        <i class="fa-solid fa-newspaper text-5xl"></i>
                                    </div>
                                @endif
                            </a>
                        </div>
                        <div class="news-card-content">
                            <div class="news-card-meta">
                                <span><i class="fa-solid fa-calendar-days mr-2"></i> {{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}</span>
                                <span><i class="fa-solid fa-eye mr-2"></i> {{ number_format($post->views) }}</span>
                            </div>
                            <h3 class="news-card-title">
                                <a href="{{ route('news.detail', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="news-card-desc">
                                {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            <div class="news-card-footer">
                                <a href="{{ route('news.detail', $post->slug) }}" class="text-primary font-bold text-sm tracking-wide group flex items-center gap-1">
                                    Chi tiết <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="lg:col-span-2 text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
                        <i class="fa-solid fa-magnifying-glass text-5xl text-gray-200 mb-4"></i>
                        <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">Không tìm thấy bài viết phù hợp</p>
                    </div>
                    @endforelse
                </div>

                <div class="pagination-wrapper flex justify-center">
                    {{ $news->links() }}
                </div>
            </div>

            {{-- Right: Sidebar --}}
            <aside class="lg:col-span-4 space-y-8">
                {{-- Search Widget --}}
                <div class="widget">
                    <h4 class="widget-title">Tìm kiếm</h4>
                    <form action="{{ route('news') }}" method="GET" class="search-box">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Bạn muốn tìm gì..." class="search-input">
                        <i class="fa-solid fa-search"></i>
                    </form>
                </div>

                {{-- Categories Widget --}}
                <div class="widget">
                    <h4 class="widget-title">Danh mục</h4>
                    <div class="category-list">
                        <a href="{{ route('news') }}" class="category-item {{ !request('category') ? 'active' : '' }}">
                            <span>Tất cả</span>
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('news', ['category' => $cat->slug]) }}" class="category-item {{ request('category') == $cat->slug ? 'active' : '' }}">
                            <span>{{ $cat->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Featured Post Widget --}}
                <div class="widget">
                    <h4 class="widget-title">Tin nổi bật</h4>
                    <div class="space-y-6">
                        @foreach($featuredNews as $fPost)
                        <div class="featured-item group">
                            <div class="featured-thumb">
                                <img src="{{ asset('storage/' . $fPost->image) }}" class="group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="featured-content">
                                <span class="text-[10px] font-bold text-primary uppercase mb-1">{{ $fPost->category->name ?? 'Hot' }}</span>
                                <h5 class="text-sm font-bold leading-tight group-hover:text-primary transition-colors">
                                    <a href="{{ route('news.detail', $fPost->slug) }}">{{ Str::limit($fPost->title, 45) }}</a>
                                </h5>
                                <span class="text-[10px] text-gray-400 mt-2 font-semibold"><i class="fa-regular fa-clock mr-1"></i> {{ $fPost->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tags Widget --}}
                <div class="widget">
                    <h4 class="widget-title">Tags phổ biến</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <a href="{{ route('news', ['tag' => $tag]) }}" 
                           class="px-3 py-1.5 bg-white border border-gray-100 rounded-lg text-[11px] font-bold text-slate-500 hover:border-primary hover:text-primary transition-all shadow-sm">
                            #{{ $tag }}
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Recommended Section/Placeholder --}}
                <div class="widget">
                    <div class="bg-primary/5 p-8 rounded-3xl border border-primary/10">
                        <h4 class="font-black text-slate-900 uppercase tracking-tighter mb-2 italic small">Elite Fitness+</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Bắt đầu hành trình thay đổi vóc dáng cùng đội ngũ chuyên gia hàng đầu.</p>
                        <a href="{{ route('client.memberships') }}" class="mt-4 inline-block text-[10px] font-black uppercase tracking-widest text-primary hover:text-orange-700 transition-colors">Tìm hiểu thêm →</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Reveal animation logic (reuse if in main.js)
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-on-scroll').forEach((el) => observer.observe(el));
</script>
@endsection
