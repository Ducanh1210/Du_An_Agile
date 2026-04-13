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
                
                {{-- Blog Item 1 --}}
                <article class="blog-item-card animate-on-scroll">
                    <a href="{{ url('/tin-tuc/1') }}" class="blog-item-img-wrap">
                        <img src="https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=800&q=80&auto=format&fit=crop" alt="Blog Thumb" class="blog-item-img">
                    </a>
                    <div class="blog-item-body">
                        <div class="blog-meta-info" style="margin-bottom: 12px; border-bottom: none; padding-bottom: 0;">
                            <span><i class="fas fa-tag"></i> Đạp xe</span>
                            <span><i class="fas fa-calendar-alt"></i> 20 Tháng 3, 2025</span>
                            <span><i class="fas fa-comments"></i> 5 Bình luận</span>
                        </div>
                        <h2 class="blog-item-title">
                            <a href="{{ url('/tin-tuc/1') }}">Indoor Cycling — Những điều cần biết trước buổi tập đầu tiên</a>
                        </h2>
                        <p class="blog-item-excerpt">
                            Đó là khoảnh khắc mà nhiều người đam mê đạp xe hoặc các bộ môn cardio mơ ước khi hoàn thành xong một buổi tập nặng: Khoảng thời gian vài tuần trước ngày thi đấu khi...
                        </p>
                        <a href="{{ url('/tin-tuc/1') }}" class="read-more-btn">ĐỌC TIẾP <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                {{-- Blog Item 2 --}}
                <article class="blog-item-card animate-on-scroll">
                    <a href="{{ url('/tin-tuc/2') }}" class="blog-item-img-wrap">
                        <img src="https://images.unsplash.com/photo-1571019614242-c5c5adee9f50?w=800&q=80&auto=format&fit=crop" alt="Blog Thumb" class="blog-item-img">
                    </a>
                    <div class="blog-item-body">
                        <div class="blog-meta-info" style="margin-bottom: 12px; border-bottom: none; padding-bottom: 0;">
                            <span><i class="fas fa-tag"></i> Thể hình</span>
                            <span><i class="fas fa-calendar-alt"></i> 18 Tháng 3, 2025</span>
                            <span><i class="fas fa-comments"></i> 3 Bình luận</span>
                        </div>
                        <h2 class="blog-item-title">
                            <a href="{{ url('/tin-tuc/2') }}">Crunches có phải là bài tập tốt nhất cho cơ bụng?</a>
                        </h2>
                        <p class="blog-item-excerpt">
                            Nhiều người lầm tưởng tập bụng càng nhiều thì vòng eo càng thon gọn. Tuy nhiên, sự thật là việc sở hữu vòng hai săn chắc đòi hỏi sự kết hợp toàn diện giữa...
                        </p>
                        <a href="{{ url('/tin-tuc/2') }}" class="read-more-btn">ĐỌC TIẾP <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

                {{-- Blog Item 3 --}}
                <article class="blog-item-card animate-on-scroll">
                    <a href="{{ url('/tin-tuc/3') }}" class="blog-item-img-wrap">
                        <img src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?w=800&q=80&auto=format&fit=crop" alt="Blog Thumb" class="blog-item-img">
                    </a>
                    <div class="blog-item-body">
                        <div class="blog-meta-info" style="margin-bottom: 12px; border-bottom: none; padding-bottom: 0;">
                            <span><i class="fas fa-tag"></i> Phục hồi</span>
                            <span><i class="fas fa-calendar-alt"></i> 15 Tháng 3, 2025</span>
                            <span><i class="fas fa-comments"></i> 8 Bình luận</span>
                        </div>
                        <h2 class="blog-item-title">
                            <a href="{{ url('/tin-tuc/3') }}">Cách ngăn chặn chứng chuột rút cơ bắp ngay lập tức</a>
                        </h2>
                        <p class="blog-item-excerpt">
                            Chuột rút có thể hủy hoại hoàn toàn một buổi tập hoàn hảo của bạn. Tìm hiểu nguyên nhân sâu xa và các mẹo giãn cơ hiệu quả nhất để phòng tránh trước khi...
                        </p>
                        <a href="{{ url('/tin-tuc/3') }}" class="read-more-btn">ĐỌC TIẾP <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>

            </div>

            {{-- Pagination --}}
            <div class="blog-pagination animate-on-scroll delay-1">
                <a href="#" class="page-btn active">1</a>
                <a href="#" class="page-btn">2</a>
                <a href="#" class="page-btn">3</a>
                <span style="color:var(--color-text-muted); padding:0 8px;">...</span>
                <a href="#" class="page-btn next-btn">Tiếp theo <i class="fas fa-angle-right"></i></a>
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
                    <a href="{{ url('/tin-tuc/4') }}" class="recent-news-item">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=200&q=80&auto=format&fit=crop" class="recent-news-thumb" alt="News">
                        <div class="recent-news-title">5 Bí quyết tập gym hiệu quả cho người mới bắt đầu</div>
                    </a>
                    <a href="{{ url('/tin-tuc/5') }}" class="recent-news-item">
                        <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=200&q=80&auto=format&fit=crop" class="recent-news-thumb" alt="News">
                        <div class="recent-news-title">Chế độ dinh dưỡng tối ưu để tăng cơ giảm mỡ nhanh nhất</div>
                    </a>
                    <a href="{{ url('/tin-tuc/6') }}" class="recent-news-item">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=200&q=80&auto=format&fit=crop" class="recent-news-thumb" alt="News">
                        <div class="recent-news-title">Chạy đua đạt đỉnh dễ dàng với những tip hoàn hảo</div>
                    </a>
                    <a href="{{ url('/tin-tuc/7') }}" class="recent-news-item">
                        <img src="https://images.unsplash.com/photo-1583454110551-21f2fa2afe61?w=200&q=80&auto=format&fit=crop" class="recent-news-thumb" alt="News">
                        <div class="recent-news-title">13 Cách để nâng tạ hiệu quả và an toàn hơn</div>
                    </a>
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
