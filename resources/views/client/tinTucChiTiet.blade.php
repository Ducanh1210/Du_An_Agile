@extends('layouts.client')

@section('title', 'Indoor Cycling — Những điều cần biết trước buổi tập đầu tiên | EXTRA FIT+')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
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
                <img src="https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=1200&q=80&auto=format&fit=crop" alt="Indoor Cycling" class="blog-header-img">
                
                <div class="blog-body">
                    <div class="blog-meta-tags">
                        <span class="blog-meta-tag">Đạp xe trong nhà</span>
                        <span class="blog-meta-tag">Giảm cân</span>
                    </div>

                    <h2 class="blog-title">Indoor Cycling — Những điều cần biết trước buổi tập đầu tiên</h2>

                    <div class="blog-meta-info">
                        <span><i class="fas fa-user"></i> Quản trị viên</span>
                        <span><i class="fas fa-calendar-alt"></i> 20 Tháng 3, 2025</span>
                        <span><i class="fas fa-comments"></i> 2 Bình luận</span>
                    </div>

                    <div class="blog-text-content">
                        <p>Đó là khoảnh khắc mà nhiều người đam mê đạp xe hoặc các bộ môn cardio mơ ước khi hoàn thành xong một buổi tập nặng: Khoảng thời gian vài tuần trước ngày thi đấu khi chương trình tập luyện yêu cầu ít vận động hơn và chú trọng vào việc phục hồi, hay còn gọi là quá trình taper.</p>

                        <p>Tapering cho phép cơ thể bạn "sửa chữa, bổ sung và sắp xếp lại" để chuẩn bị cho ngày quyết định. Nhưng mặc dù việc nghỉ ngơi khỏi lịch trình luyện tập gian khổ có vẻ hấp dẫn, nó đôi khi lại tạo cảm giác không quen thuộc khi bạn ít vận động hơn trước. Một chiến lược taper đáng tin cậy — đơn giản để thực hiện với hướng dẫn dưới đây từ các chuyên gia — sẽ giúp bạn khỏe mạnh và mạnh mẽ cho ngày đua.</p>

                        <h4>Những Lợi Ích Cốt Lõi</h4>
                        <ul>
                            <li><i class="fas fa-check" style="color:var(--color-primary); margin-right:8px;"></i> Đốt cháy hàng lượng calo khổng lồ (400-600 calo/buổi)</li>
                            <li><i class="fas fa-check" style="color:var(--color-primary); margin-right:8px;"></i> Cải thiện sức khỏe tim mạch và sức bền</li>
                            <li><i class="fas fa-check" style="color:var(--color-primary); margin-right:8px;"></i> Phát triển cơ bắp chân, đùi và vùng lõi (core)</li>
                            <li><i class="fas fa-check" style="color:var(--color-primary); margin-right:8px;"></i> Giảm căng thẳng cực kỳ hiệu quả thông qua hoạt động nhóm</li>
                        </ul>

                        <h4>Những Cạm Bẫy Cần Tránh: Hãy Tin Tưởng Vào Taper</h4>
                        <p>Sự cám dỗ về việc nghỉ ngơi quá mức hoặc không nghỉ ngơi đủ có thể khiến cho việc taper trở nên khó khăn. Bạn có thể cảm thấy kỳ lạ khi tập luyện ít hơn so với thông thường. Chuyên gia của chúng tôi khuyên bạn nên bỏ qua cả "những cơn đau ảo" và "sự nghi ngờ len lỏi". Rõ ràng rằng việc giảm số km, duy trì cường độ và tự chăm sóc bản thân là những phương pháp vinh danh thời gian và được khoa học kiểm chứng.</p>

                        <blockquote class="blog-blockquote">
                            "Bạn không thể xâu chuỗi các điểm nhìn về phía trước; bạn chỉ có thể xâu chuỗi chúng khi nhìn về quá khứ. Vì vậy bạn phải tin rằng các điểm sẽ kết nối ở tương lai của bạn. Cách tiếp cận này chưa bao giờ làm tôi thất vọng, và nó đã tạo ra mọi sự khác biệt trong cuộc đời tôi."
                        </blockquote>

                        <p>Bạn cũng được khuyên tránh thử bất cứ điều gì mới mẻ trong khoảng thời gian này, như một đôi giày mới hay một nhóm luyện tập và quy trình mới. “Hãy giữ mọi sự đơn giản và không áp lực trong những tuần taper đó,” cô ấy nói.</p>

                    </div>

                    {{-- Blog Footer: Tags & Share --}}
                    <div class="blog-footer">
                        <div class="blog-tags">
                            <span class="blog-tags-label">Tags:</span>
                            <a href="#" class="tag-btn">Đạp xe</a>
                            <a href="#" class="tag-btn">HLV</a>
                            <a href="#" class="tag-btn">Cardio</a>
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
                <h3 class="comments-title">2 Bình Luận</h3>

                <div class="comment-list">
                    {{-- Comment 1 --}}
                    <div class="comment-item">
                        <img src="https://ui-avatars.com/api/?name=Brandon+Kelley&background=FF6B35&color=fff&size=56" alt="Avatar" class="comment-avatar">
                        <div class="comment-body">
                            <div class="comment-header">
                                <span class="comment-author">Brandon Kelley</span>
                                <span class="comment-date">21 Tháng 3, 2025</span>
                            </div>
                            <p class="comment-text">Bản thân tôi cũng là một người đam mê đạp xe và bài viết này cực kỳ chính xác. Tôi vừa tham gia lớp Indoor Cycling chạy thử tuần trước và nó tuyệt vời quá chừng, calo đốt cháy không tưởng.</p>
                            <a href="#leaveCommentForm" class="comment-reply"><i class="fas fa-reply"></i> Trả lời</a>
                        </div>
                    </div>

                    {{-- Comment 2 --}}
                    <div class="comment-item" style="margin-left: 56px;">
                        <img src="https://ui-avatars.com/api/?name=EXTRA+FIT&background=1A1A2E&color=fff&size=56" alt="Avatar" class="comment-avatar" style="border-width: 2px;">
                        <div class="comment-body">
                            <div class="comment-header">
                                <span class="comment-author">Admin EXTRA FIT+</span>
                                <span class="comment-date">22 Tháng 3, 2025</span>
                            </div>
                            <p class="comment-text">Cảm ơn đánh giá của Brandon! Chúc bạn có những giờ tập hiệu quả nhất với trung tâm chúng tôi. Hẹn gặp bạn ở các buổi tiếp theo nhé.</p>
                            <a href="#leaveCommentForm" class="comment-reply"><i class="fas fa-reply"></i> Trả lời</a>
                        </div>
                    </div>
                </div>

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
                        <button type="submit" class="btn btn-primary btn-lg mt-1">Gửi Bình Luận</button>
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
                    <a href="#" class="recent-news-item">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=200&q=80&auto=format&fit=crop" class="recent-news-thumb" alt="News">
                        <div class="recent-news-title">5 Bí quyết tập gym hiệu quả cho người mới bắt đầu</div>
                    </a>
                    <a href="#" class="recent-news-item">
                        <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=200&q=80&auto=format&fit=crop" class="recent-news-thumb" alt="News">
                        <div class="recent-news-title">Chế độ dinh dưỡng tối ưu để tăng cơ giảm mỡ nhanh nhất</div>
                    </a>
                    <a href="#" class="recent-news-item">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=200&q=80&auto=format&fit=crop" class="recent-news-thumb" alt="News">
                        <div class="recent-news-title">Chạy đua đạt đỉnh dễ dàng với những tip hoàn hảo</div>
                    </a>
                    <a href="#" class="recent-news-item">
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
