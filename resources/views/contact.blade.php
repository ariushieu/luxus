@extends('layouts.app')

@section('title', 'Liên hệ - LUXUS Interior Design | Tư vấn thiết kế miễn phí')

@push('styles')
<style>
    /* Enhanced Contact Page Styles */
    .contact-hero {
        height: 450px;
        background: linear-gradient(135deg, rgba(44, 36, 22, 0.92), rgba(107, 68, 35, 0.85)),
            url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1920') center/cover;
        position: relative;
    }

    .contact-info-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: var(--shadow-md);
        height: 100%;
        transition: all 0.3s ease;
        border-top: 4px solid var(--secondary-color);
    }

    .contact-info-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    .contact-icon-box {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--accent-gold), var(--secondary-color));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin: 0 auto 1.5rem;
        box-shadow: var(--shadow-md);
    }

    .nav-tabs .nav-link {
        border: none;
        color: var(--text-medium);
        font-weight: 600;
        padding: 1rem 2rem;
        transition: all 0.3s;
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        background: var(--accent-cream);
        border-radius: 8px 8px 0 0;
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
    }
</style>
@endpush

@section('content')
<!-- Enhanced Page Header -->
<div class="contact-hero hero-section">
    <div class="hero-content">
        <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                     letter-spacing: 3px; font-size: 1rem;">Kết nối với chúng tôi</span>
        <h1 style="margin-top: 1rem;">Liên hệ</h1>
        <p style="font-size: 1.4rem; margin-top: 1rem;">Let's Create Something Beautiful Together</p>
        <div style="width: 80px; height: 3px; background: var(--secondary-color); margin: 1.5rem auto 0;"></div>
        <p style="font-size: 1.1rem; margin-top: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Chúng tôi luôn sẵn sàng lắng nghe và tư vấn miễn phí cho dự án của bạn
        </p>
    </div>
</div>

<!-- Quick Contact Cards -->
<section class="py-5" style="background-color: var(--accent-cream); margin-top: -50px; position: relative; z-index: 2;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="contact-info-card text-center">
                    <div class="contact-icon-box">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1rem;">Hotline</h5>
                    <p style="color: var(--text-medium); margin-bottom: 0.5rem;">Gọi cho chúng tôi</p>
                    <a href="tel:+84123456789" style="color: var(--secondary-color); font-weight: 600; font-size: 1.2rem; text-decoration: none;">
                        +84 123 456 789
                    </a>
                    <p style="color: var(--text-light); margin-top: 1rem; font-size: 0.9rem;">
                        Thứ 2 - Thứ 6: 8:00 - 18:00<br>Thứ 7: 8:00 - 12:00
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-info-card text-center">
                    <div class="contact-icon-box">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1rem;">Email</h5>
                    <p style="color: var(--text-medium); margin-bottom: 0.5rem;">Gửi email cho chúng tôi</p>
                    <a href="mailto:contact@luxus.com" style="color: var(--secondary-color); font-weight: 600; font-size: 1.2rem; text-decoration: none;">
                        contact@luxus.com
                    </a>
                    <p style="color: var(--text-light); margin-top: 1rem; font-size: 0.9rem;">
                        Phản hồi trong vòng 24h<br>Tư vấn miễn phí
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-info-card text-center">
                    <div class="contact-icon-box">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1rem;">Văn phòng</h5>
                    <p style="color: var(--text-medium); margin-bottom: 0.5rem;">Ghé thăm showroom</p>
                    <p style="color: var(--secondary-color); font-weight: 600; font-size: 1.1rem; margin: 0.5rem 0;">
                        Hà Nội, Việt Nam
                    </p>
                    <p style="color: var(--text-light); margin-top: 1rem; font-size: 0.9rem;">
                        Đặt lịch hẹn trước<br>để được phục vụ tốt nhất
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Forms Section -->
<section class="py-5" style="background: white;">
    <div class="container">
        <!-- Toast Container -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999; margin-top: 80px;">
            @if(session('success'))
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="successToast">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Thành công!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="errorToast">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Lỗi!</strong>
                        @foreach($errors->all() as $error)
                        {{ $error }}<br>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            @endif
        </div>

        <div class="row">
            <!-- Left Column - Forms -->
            <div class="col-lg-8 mb-4" data-aos="fade-right">

                <div class="contact-form">
                    <h3 style="font-family: 'Cormorant Garamond', serif; color: var(--primary-color); 
                               font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">
                        Gửi yêu cầu của bạn
                    </h3>
                    <p style="color: var(--text-medium); margin-bottom: 2rem;">
                        Điền thông tin bên dưới và chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất
                    </p>

                    <ul class="nav nav-tabs mb-4" role="tablist" style="border-bottom: 2px solid var(--accent-gold);">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#booking" type="button">
                                <i class="fas fa-calendar-check me-2"></i>Đặt lịch tư vấn
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#quote" type="button">
                                <i class="fas fa-file-invoice me-2"></i>Yêu cầu báo giá
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Booking Tab -->
                        <div class="tab-pane fade show active" id="booking">
                            <div class="mb-4">
                                <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 0.5rem;">
                                    <i class="fas fa-calendar-check me-2" style="color: var(--secondary-color);"></i>
                                    Đặt lịch tư vấn miễn phí
                                </h5>
                                <p style="color: var(--text-medium);">
                                    Đặt lịch hẹn để gặp trực tiếp đội ngũ chuyên gia của chúng tôi
                                </p>
                            </div>

                            <form action="{{ route('booking.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                            <i class="fas fa-user me-2" style="color: var(--secondary-color);"></i>Họ tên *
                                        </label>
                                        <input type="text" name="client_name" class="form-control"
                                            placeholder="Nguyễn Văn A" required>
                                        @error('client_name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                            <i class="fas fa-envelope me-2" style="color: var(--secondary-color);"></i>Email *
                                        </label>
                                        <input type="email" name="client_email" class="form-control"
                                            placeholder="email@example.com" required>
                                        @error('client_email')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                            <i class="fas fa-phone me-2" style="color: var(--secondary-color);"></i>Số điện thoại *
                                        </label>
                                        <input type="tel" name="client_phone" class="form-control"
                                            placeholder="0123 456 789" required>
                                        @error('client_phone')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                            <i class="fas fa-calendar me-2" style="color: var(--secondary-color);"></i>Thời gian mong muốn *
                                        </label>
                                        <input type="datetime-local" name="booking_time" class="form-control" required>
                                        @error('booking_time')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                        <i class="fas fa-comment-dots me-2" style="color: var(--secondary-color);"></i>Nội dung tư vấn
                                    </label>
                                    <textarea name="message" class="form-control" rows="5"
                                        placeholder="Hãy cho chúng tôi biết bạn cần tư vấn về vấn đề gì: thiết kế nhà ở, văn phòng, showroom..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary-custom btn-lg w-100"
                                    style="padding: 15px; font-size: 1.05rem;">
                                    <i class="fas fa-calendar-check me-2"></i>Đặt lịch ngay
                                </button>
                            </form>
                        </div> <!-- Quote Tab -->
                        <div class="tab-pane fade" id="quote">
                            <div class="mb-4">
                                <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 0.5rem;">
                                    <i class="fas fa-file-invoice me-2" style="color: var(--secondary-color);"></i>
                                    Yêu cầu báo giá dự án
                                </h5>
                                <p style="color: var(--text-medium);">
                                    Cung cấp thông tin chi tiết để nhận được báo giá chính xác nhất
                                </p>
                            </div>

                            <form action="{{ route('quote.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                            <i class="fas fa-user me-2" style="color: var(--secondary-color);"></i>Họ tên *
                                        </label>
                                        <input type="text" name="client_name" class="form-control"
                                            placeholder="Nguyễn Văn A" required>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                            <i class="fas fa-envelope me-2" style="color: var(--secondary-color);"></i>Email *
                                        </label>
                                        <input type="email" name="client_email" class="form-control"
                                            placeholder="email@example.com" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                            <i class="fas fa-phone me-2" style="color: var(--secondary-color);"></i>Số điện thoại *
                                        </label>
                                        <input type="tel" name="client_phone" class="form-control"
                                            placeholder="0123 456 789" required>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                            <i class="fas fa-building me-2" style="color: var(--secondary-color);"></i>Loại dự án *
                                        </label>
                                        <select name="project_type" class="form-select" required>
                                            <option value="">Chọn loại dự án</option>
                                            <option value="housing">Nhà ở / Housing</option>
                                            <option value="commercial">Thương mại / Commercial</option>
                                            <option value="office">Văn phòng / Office</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                            <i class="fas fa-ruler-combined me-2" style="color: var(--secondary-color);"></i>Diện tích (m²)
                                        </label>
                                        <input type="number" name="area" class="form-control" step="0.01"
                                            placeholder="VD: 120">
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                            <i class="fas fa-dollar-sign me-2" style="color: var(--secondary-color);"></i>Ngân sách dự kiến (VNĐ)
                                        </label>
                                        <input type="number" name="budget" class="form-control" step="1000000"
                                            placeholder="VD: 500,000,000">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">
                                        <i class="fas fa-list-ul me-2" style="color: var(--secondary-color);"></i>Yêu cầu chi tiết *
                                    </label>
                                    <textarea name="request_details" class="form-control" rows="5" required
                                        placeholder="Mô tả chi tiết về dự án: số phòng, phong cách thiết kế, thời gian thực hiện..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary-custom btn-lg w-100"
                                    style="padding: 15px; font-size: 1.05rem;">
                                    <i class="fas fa-paper-plane me-2"></i>Gửi yêu cầu báo giá
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Additional Info -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="info-card mb-4">
                    <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1.5rem;">
                        <i class="fas fa-question-circle me-2"></i>Câu hỏi thường gặp
                    </h5>
                    <div class="mb-3">
                        <h6 style="color: var(--text-dark); font-weight: 600;">Thời gian tư vấn mất bao lâu?</h6>
                        <p style="color: var(--text-medium); font-size: 0.95rem; margin: 0;">
                            Buổi tư vấn thường kéo dài 30-60 phút tùy theo độ phức tạp của dự án.
                        </p>
                    </div>
                    <hr style="border-color: var(--accent-gold);">
                    <div class="mb-3">
                        <h6 style="color: var(--text-dark); font-weight: 600;">Chi phí tư vấn như thế nào?</h6>
                        <p style="color: var(--text-medium); font-size: 0.95rem; margin: 0;">
                            Buổi tư vấn đầu tiên hoàn toàn miễn phí. Chúng tôi sẽ thảo luận chi tiết về dự án của bạn.
                        </p>
                    </div>
                    <hr style="border-color: var(--accent-gold);">
                    <div>
                        <h6 style="color: var(--text-dark); font-weight: 600;">Tôi cần chuẩn bị gì?</h6>
                        <p style="color: var(--text-medium); font-size: 0.95rem; margin: 0;">
                            Hãy chuẩn bị bản vẽ mặt bằng (nếu có), ý tưởng về phong cách và ngân sách dự kiến.
                        </p>
                    </div>
                </div>

                <!-- <div class="info-card">
                    <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1.5rem;">
                        <i class="fas fa-headset me-2"></i>Hỗ trợ khách hàng
                    </h5>
                    <p style="color: var(--text-medium); margin-bottom: 1.5rem;">
                        Đội ngũ của chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7
                    </p>
                    <div class="d-grid gap-2">
                        <a href="tel:+84123456789" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>Gọi ngay: +84 123 456 789
                        </a>
                        <a href="https://facebook.com/luxus" target="_blank" class="btn btn-outline-primary">
                            <i class="fab fa-facebook-messenger me-2"></i>Chat Facebook
                        </a>
                        <a href="#" class="btn btn-outline-success">
                            <i class="fab fa-weixin me-2"></i>Chat WeChat
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5">
            <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                         letter-spacing: 2px; font-size: 0.9rem;">Ghé thăm chúng tôi</span>
            <h2 class="section-title" style="margin-top: 1rem;">Vị trí văn phòng</h2>
            <p class="section-subtitle">
                Hẹn gặp bạn tại showroom và văn phòng của LUXUS
            </p>
        </div>
        <div class="ratio ratio-21x9 shadow-custom" style="border-radius: 12px; overflow: hidden;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.096888659277!2d105.84117631533213!3d21.028511993674482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9bd9861ca1%3A0xe7887f7b72ca17!2zSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1234567890123!5m2!1svi!2s"
                style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Auto-hide toasts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast.show');
        toasts.forEach(toast => {
            setTimeout(() => {
                const bsToast = new bootstrap.Toast(toast);
                bsToast.hide();
            }, 5000);
        });
    });

    // Form validation enhancement
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi...';
            }
        });
    });
</script>
@endpush

@endsection