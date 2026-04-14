@extends('layouts.client')

@section('title', 'Tin Tức & Sự Kiện | EXTRA FIT+')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endsection

@section('breadcrumb')
<nav class="breadcrumb" aria-label="breadcrumb">
    <div class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></div>
    <span class="breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
    <div class="breadcrumb-item active" aria-current="page">Tin tức</div>
</nav>
@endsection

@section('content')

{{-- ============================================================
     PAGE BANNER
     ============================================================ --}}
<section class="page-banner" aria-label="Banner Tin Tức">
    <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=1600&q=80&auto=format&fit=crop"
         alt="Tin tức background" class="page-banner-bg" loading="lazy">
    <div class="page-banner-overlay"></div>
    <div class="page-banner-content container">
        <h1 class="page-banner-title animate-on-scroll">Tin Tức & Sự Kiện</h1>
    </div>
</section>

{{-- ============================================================
     BLOG LIST SECTION
     ============================================================ --}}
<section class="section blog-section">
    <div class="container blog-layout">
        
        {{-- MAIN CONTENT: NEWS LIST --}}
        <main class="main-content">
            <div class="blog-list">
                @forelse($news as $item)
                {{-- Blog Item --}}
                <article class="blog-item-card animate-on-scroll">
                    <a href="{{ route('news.detail', $item->id) }}" class="blog-item-img-wrap">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="blog-item-img">
                        @else
                            <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=800&q=80&auto=format&fit=crop" alt="Default image" class="blog-item-img">
                        @endif
                    </a>
                    <div class="blog-item-body">
                        <div class="blog-meta-info" style="margin-bottom: 12px; border-bottom: none; padding-bottom: 0;">
                            <span><i class="fas fa-calendar-alt"></i> {{ $item->created_at->format('d/m/Y') }}</span>
                        </div>
                        <h2 class="blog-item-title" style="font-family: '{{ $item->title_font_family }}'; font-size: {{ $item->title_font_size * 0.8 }}px; text-transform: uppercase;">
                            <a href="{{ route('news.detail', $item->id) }}">{{ $item->title }}</a>
                        </h2>
                        <div class="blog-item-excerpt" style="text-transform: lowercase;">
                            {{ Str::limit(strip_tags($item->content), 150) }}
                        </div>
                        <a href="{{ route('news.detail', $item->id) }}" class="read-more-btn">ĐỌC TIẾP <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
                @empty
                <div class="text-center py-20 bg-slate-50 rounded-3xl">
                    <i class="far fa-newspaper text-5xl text-slate-300 mb-4"></i>
                    <p class="text-slate-500 font-medium uppercase tracking-widest">Hiện chưa có tin tức nào được đăng.</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="blog-pagination animate-on-scroll delay-1">
                {{ $news->links() }}
            </div>

        </main>

        {{-- SIDEBAR --}}
        <aside class="blog-sidebar">
            
            {{-- Search Widget --}}
            <div class="sidebar-widget animate-on-scroll delay-1">
                <form action="#" class="sidebar-search" onsubmit="event.preventDefault(); showToast('info', 'Tìm kiếm', 'Chức năng đang cập nhật.');">
                    <div class="form-group" style="position:relative; margin-bottom:0;">
                        <input type="text" class="form-control" placeholder="Tìm kiếm bài viết..." style="padding-right:48px;">
                        <button type="submit" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); background:transparent; border:none; color:var(--color-primary); font-size:18px; cursor:pointer;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Recent News Widget --}}
            <div class="sidebar-widget animate-on-scroll delay-2">
                <h4 class="widget-title">Bài Viết Gần Đây</h4>
                <div class="recent-news-list">
                    @foreach($recentNews as $recent)
                    <a href="{{ route('news.detail', $recent->id) }}" class="recent-news-item">
                        @if($recent->image)
                            <img src="{{ asset('storage/' . $recent->image) }}" class="recent-news-thumb" alt="{{ $recent->title }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=200&q=80&auto=format&fit=crop" class="recent-news-thumb" alt="News">
                        @endif
                        <div class="recent-news-title uppercase" style="font-family: '{{ $recent->title_font_family }}'; font-size: 11px;">{{ $recent->title }}</div>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Categories Widget --}}
            <div class="sidebar-widget animate-on-scroll delay-3">
                <h4 class="widget-title">Danh Mục Thể Thao</h4>
                <div class="category-list">
                    <a href="#" class="category-item">
                        <span>Thể hình (Body Building)</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <a href="#" class="category-item">
                        <span>Giáo án HLV (Gym Trainer)</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <a href="#" class="category-item">
                        <span>Đạp xe (Free Cycling)</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <a href="#" class="category-item">
                        <span>Cardio (Cardio Class)</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <a href="#" class="category-item">
                        <span>Dinh dưỡng (Food Healthy)</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Popular Tags Widget --}}
            <div class="sidebar-widget animate-on-scroll delay-4">
                <h4 class="widget-title">Tags Phổ Biến</h4>
                <div class="tags-list">
                    <a href="#" class="tag-btn">Đạp xe</a>
                    <a href="#" class="tag-btn">Thể hình</a>
                    <a href="#" class="tag-btn">Tập tạ</a>
                    <a href="#" class="tag-btn">Giảm cân</a>
                    <a href="#" class="tag-btn">HLV cá nhân</a>
                    <a href="#" class="tag-btn">Sức bền</a>
                    <a href="#" class="tag-btn">Dinh dưỡng</a>
                </div>
            </div>

        </aside>

    </div>
</section>

@endsection
