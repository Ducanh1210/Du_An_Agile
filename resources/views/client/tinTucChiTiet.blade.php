@extends('layouts.client')

@section('title', $news->title . ' | EXTRA FIT+')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Montserrat:wght@400;700&family=Oswald:wght@400;700&family=Playfair+Display:wght@400;700&family=Quicksand:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
@endsection

@section('breadcrumb')
<nav class="breadcrumb" aria-label="breadcrumb">
    <div class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></div>
    <span class="breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
    <div class="breadcrumb-item"><a href="{{ url('/tin-tuc') }}">Tin tức</a></div>
    <span class="breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
    <div class="breadcrumb-item active" aria-current="page">Chi tiết bài viết</div>
</nav>
@endsection

@section('content')

{{-- ============================================================
     PAGE BANNER
     ============================================================ --}}
<section class="page-banner" aria-label="Banner Tin Tức">
    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=1600&q=80&auto=format&fit=crop"
         alt="Tin tức background" class="page-banner-bg" loading="lazy">
    <div class="page-banner-overlay"></div>
    <div class="page-banner-content container">
        <h1 class="page-banner-title animate-on-scroll">Tin Tức & Kiến Thức</h1>
    </div>
</section>

{{-- ============================================================
     BLOG CONTENT SECTION
     ============================================================ --}}
<section class="section blog-section">
    <div class="container blog-layout">
        
        {{-- MAIN CONTENT --}}
        <main class="main-content">
            
            <article class="blog-content animate-on-scroll">
                @if($news->image)
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="blog-header-img">
                @else
                    <img src="https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=1200&q=80&auto=format&fit=crop" alt="Default Header" class="blog-header-img">
                @endif
                
                <div class="blog-body">
                    <h2 class="blog-title" style="font-family: '{{ $news->title_font_family }}'; font-size: {{ $news->title_font_size }}px; text-transform: uppercase; line-height: 1.2;">
                        {{ $news->title }}
                    </h2>

                    <div class="blog-meta-info">
                        <span><i class="fas fa-user"></i> Quản trị viên</span>
                        <span><i class="fas fa-calendar-alt"></i> {{ $news->created_at->format('d/m/Y') }}</span>
                    </div>

                    <div class="blog-text-content" style="text-transform: lowercase; font-size: 1.1rem; line-height: 1.8; color: #4b5563;">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    {{-- Blog Footer: Tags & Share --}}
                    <div class="blog-footer">
                        <div class="blog-tags">
                            <span class="blog-tags-label">Tags:</span>
                            <a href="#" class="tag-btn">Tin tức</a>
                            <a href="#" class="tag-btn">Sự kiện</a>
                        </div>

                        <div class="blog-share">
                            <span class="blog-share-label">Chia sẻ:</span>
                            <div class="blog-share-links">
                                <button class="share-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></button>
                                <button class="share-link" aria-label="Twitter"><i class="fab fa-twitter"></i></button>
                                <button class="share-link" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></button>
                                <button class="share-link" aria-label="Copy Link"><i class="fas fa-link"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            {{-- COMMENTS AREA --}}
            <div class="comments-section animate-on-scroll delay-1">
                <h3 class="comments-title">0 Bình Luận</h3>

                {{-- Leave A Comment Form --}}
                <div class="leave-comment-form" id="leaveCommentForm">
                    <h4>Để Lại Bình Luận</h4>
                    <form action="#" method="POST" onsubmit="event.preventDefault(); showToast('success', 'Thành công', 'Bình luận của bạn đã được gửi và đang chờ duyệt.'); this.reset();">
                        <div class="form-row">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Tên / Biệt danh của bạn *" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email của bạn *" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="5" placeholder="Nội dung bình luận của bạn..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg mt-1 tracking-widest uppercase font-bold text-xs px-8">Gửi Bình Luận</button>
                    </form>
                </div>

            </div>
        </main>

        {{-- SIDEBAR --}}
        <aside class="blog-sidebar">
            
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
                        <div class="recent-news-title uppercase" style="font-family: '{{ $recent->title_font_family }}'; font-size: 11px; line-height: 1.3;">{{ $recent->title }}</div>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Categories Widget --}}
            <div class="sidebar-widget animate-on-scroll delay-3">
                <h4 class="widget-title">Danh Mục</h4>
                <div class="category-list">
                    <a href="#" class="category-item">
                        <span>Tin tức chung</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <a href="#" class="category-item">
                        <span>Kiến thức tập luyện</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                    <a href="#" class="category-item">
                        <span>Dinh dưỡng</span>
                        <i class="fas fa-angle-right"></i>
                    </a>
                </div>
            </div>

        </aside>

    </div>
</section>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.share-link').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if(window.showToast) {
                window.showToast('info', 'Chia sẻ', 'Tính năng đang trong quá trình nâng cấp!');
            }
        });
    });
</script>
@endsection
