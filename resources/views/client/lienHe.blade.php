@extends('layouts.client')

@section('title', 'EXTRA FIT+ GYM & FITNESS — Liên Hệ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('breadcrumb')
<nav class="breadcrumb" aria-label="breadcrumb">
    <div class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></div>
    <span class="breadcrumb-sep"><i class="fas fa-chevron-right"></i></span>
    <div class="breadcrumb-item active" aria-current="page">Liên hệ</div>
</nav>
@endsection

@section('content')

{{-- ============================================================
     PAGE BANNER
     ============================================================ --}}
<section class="page-banner" aria-label="Banner Liên Hệ">
    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1600&q=80&auto=format&fit=crop"
         alt="Liên hệ background" class="page-banner-bg" loading="lazy">
    <div class="page-banner-overlay"></div>
    <div class="page-banner-content container">
        <h1 class="page-banner-title animate-on-scroll">Liên Hệ Với Chúng Tôi</h1>
    </div>
</section>


{{-- ============================================================
     CONTACT SECTION
     ============================================================ --}}
<section class="section contact-section" id="contactSection" aria-labelledby="contactTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-tag animate-on-scroll">Phản hồi & Tư vấn</span>
            <h2 class="section-title animate-on-scroll delay-1" id="contactTitle" style="display:none;">
                Liên Hệ
            </h2>
        </div>

        <div class="contact-grid">
            
            {{-- Contact Info Left Side --}}
            <div class="contact-info-wrapper animate-on-scroll delay-2">
                <h3 class="contact-info-title">Thông Tin Liên Hệ</h3>
                <p class="contact-info-desc">
                    EXTRA FIT+ luôn sẵn lòng lắng nghe và giải đáp mọi thắc mắc của bạn. Hãy liên hệ với chúng tôi thông qua các kênh sau.
                </p>

                <div class="contact-details">
                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="contact-detail-content">
                            <div class="cd-title">Địa chỉ</div>
                            <div class="cd-text">123 Đường Thể Thao, Quận 1, Tp. Hồ Chí Minh</div>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fas fa-phone-alt"></i></div>
                        <div class="contact-detail-content">
                            <div class="cd-title">Số điện thoại</div>
                            <div class="cd-text">0909 123 456<br>0909 654 321</div>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fas fa-envelope"></i></div>
                        <div class="contact-detail-content">
                            <div class="cd-title">Email</div>
                            <div class="cd-text">info@extrafit.vn<br>support@extrafit.vn</div>
                        </div>
                    </div>

                    <div class="contact-detail-item">
                        <div class="contact-detail-icon"><i class="fas fa-clock"></i></div>
                        <div class="contact-detail-content">
                            <div class="cd-title">Giờ hoạt động</div>
                            <div class="cd-text">T2 - T7: 5:00 - 22:00<br>Chủ Nhật: 6:00 - 20:00</div>
                        </div>
                    </div>
                </div>

                <div class="contact-social">
                    <a href="#" class="contact-social-link" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="contact-social-link" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="contact-social-link" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="contact-social-link" title="Youtube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            {{-- Form Right Side --}}
            <div class="contact-form-wrapper animate-on-scroll delay-3">
                <h3 class="contact-form-title">Gửi Lời Nhắn</h3>
                <p class="contact-form-desc">
                    Nhân viên của chúng tôi sẽ liên hệ lại với bạn trong thời gian sớm nhất.
                </p>

                <form id="contactPageForm" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="contactName">Họ và tên <span class="required">*</span></label>
                            <input type="text" id="contactName" class="form-control" placeholder="Nhập họ và tên của bạn" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contactEmail">Email <span class="required">*</span></label>
                            <input type="email" id="contactEmail" class="form-control" placeholder="Nhập địa chỉ email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contactSubject">Tiêu đề</label>
                        <input type="text" id="contactSubject" class="form-control" placeholder="Tiêu đề lời nhắn">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contactMessage">Nội dung <span class="required">*</span></label>
                        <textarea id="contactMessage" class="form-control" rows="5" placeholder="Nhập nội dung lời nhắn của bạn..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" id="submitContactBtn">
                        <i class="fas fa-paper-plane"></i> Gửi Tin Nhắn
                    </button>
                </form>
            </div>

        </div>

        {{-- Map Section --}}
        <div class="map-wrapper animate-on-scroll delay-4">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4602324213123!2d106.69707197480489!3d10.77601958937227!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f38f9ed887b%3A0x14aded5703768ddb!2z10Bo4bqhdCDEkW-DoG4gROG6rXAgSMOgbmcgSHV5w6puLCBDaMO0bmcgRMOgbSBCYWjDrW0gQmFv!5e0!3m2!1svi!2s!4v1711818223678!5m2!1svi!2s" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                title="Bản đồ địa chỉ EXTRA FIT+">
            </iframe>
        </div>

    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('contactPageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('submitContactBtn');
        const originalHtml = btn.innerHTML;
        
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
        btn.disabled = true;
        btn.classList.add('btn-loading');

        // Simulate API
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
            btn.classList.remove('btn-loading');
            
            this.reset();
            if (typeof window.showToast === 'function') {
                window.showToast('success', 'Gửi thành công!', 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ sớm phản hồi.');
            } else {
                alert('Gửi thành công! Cảm ơn bạn đã liên hệ.');
            }
        }, 1500);
    });
});
</script>
@endsection
