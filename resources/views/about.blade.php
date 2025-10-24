@extends('layouts.app')

@section('title', 'Giới thiệu - LUXUS Interior Design | Về chúng tôi')

@push('styles')
<style>
    /* Enhanced About Page Styles */
    .about-hero {
        height: 500px;
        background: linear-gradient(135deg, rgba(44, 36, 22, 0.9), rgba(107, 68, 35, 0.8)),
            url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=1920') center/cover;
        position: relative;
        overflow: hidden;
    }

    .milestone-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        border-left: 4px solid var(--secondary-color);
        height: 100%;
    }

    .milestone-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-left-width: 6px;
    }

    .milestone-year {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 1rem;
    }

    .expertise-item {
        text-align: center;
        padding: 2rem 1rem;
        transition: all 0.3s ease;
    }

    .expertise-item:hover .expertise-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .expertise-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--accent-gold), var(--secondary-color));
        border-radius: 50%;
        font-size: 2.5rem;
        color: white;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }
</style>
@endpush

@section('content')
<!-- Enhanced Page Header -->
<div class="about-hero hero-section">
    <div class="hero-content">
        <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                     letter-spacing: 3px; font-size: 1rem;">Về chúng tôi</span>
        <h1 style="margin-top: 1rem;">Giới thiệu</h1>
        <p style="font-size: 1.4rem; margin-top: 1rem;">About LUXUS</p>
        <div style="width: 80px; height: 3px; background: var(--secondary-color); margin: 1.5rem auto 0;"></div>
    </div>
</div>

<!-- Intro Section -->
<section class="py-5" style="background-color: var(--bg-white); margin-top: -50px; position: relative; z-index: 2;">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 text-center">
                <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                             letter-spacing: 2px; font-size: 0.9rem;">Câu chuyện của chúng tôi</span>
                <h2 class="section-title" style="margin-top: 1rem;">
                    {{ $settings['about_title']->value_vi ?? 'LUXUS - KIẾN TẠO KHÔNG GIAN VƯỢT TRỜI' }}
                </h2>
                <p class="lead" style="font-size: 1.2rem; line-height: 1.9; color: var(--text-medium); max-width: 900px; margin: 0 auto;">
                    {{ $settings['about_intro']->value_vi ?? 'Chào mừng bạn đến với LUXUS – nơi bạn sẽ khám phá vẻ đẹp và ý nghĩa của kiến trúc. Đây cũng chính là điểm bắt đầu trong cuộc thám hiểm tâm hồn và ý tưởng của bạn.' }}
                </p>
                @if(isset($settings['about_intro']->value_en) && $settings['about_intro']->value_en)
                <p style="font-style: italic; color: var(--text-light); margin-top: 1rem; font-size: 1.05rem;">
                    "{{ $settings['about_intro']->value_en }}"
                </p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="py-5" style="background-color: var(--accent-cream);">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <div style="position: relative;">
                    <img src="{{ $settings['about_image_1']->value_vi ?? 'https://images.unsplash.com/photo-1600210492493-0946911123ea?w=1200' }}"
                        alt="LUXUS Interior Design Office"
                        class="img-fluid shadow-custom hover-lift"
                        style="width: 100%; height: 500px; object-fit: cover; border-radius: 12px;">
                    <!-- Decorative Element -->
                    <div style="position: absolute; top: -20px; right: -20px; width: 150px; height: 150px; 
                                background: linear-gradient(135deg, var(--secondary-color), var(--primary-color)); 
                                opacity: 0.2; border-radius: 50%; z-index: -1;"></div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div style="padding-left: 2rem;">
                    <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                                 letter-spacing: 2px; font-size: 0.9rem;">Chúng tôi là ai</span>
                    <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; 
                               color: var(--primary-color); font-weight: 700; margin: 1rem 0 1.5rem; line-height: 1.2;">
                        LUXUS Interior Design
                    </h3>
                    <div style="width: 60px; height: 3px; background: var(--secondary-color); margin-bottom: 2rem;"></div>
                    <p style="line-height: 1.9; color: var(--text-medium); text-align: justify; font-size: 1.05rem;">
                        {{ $settings['about_content']->value_vi ?? 'LUXUS – đặt trụ sở tại Hà Nội, đã thực hiện nhiều dự án kiến trúc và nội thất cho các khách hàng Việt Nam và Đông Nam Á. Chúng tôi lấy tiêu chí về chất lượng cuộc sống con người, tinh thần, thẩm mỹ và công năng làm kim chỉ nam.' }}
                    </p>
                    @if(isset($settings['about_content']->value_en) && $settings['about_content']->value_en)
                    <p style="line-height: 1.9; font-style: italic; color: var(--text-light); text-align: justify; margin-top: 1.5rem;">
                        {{ $settings['about_content']->value_en }}
                    </p>
                    @endif
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="stats-card" style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                                <h4 style="color: var(--secondary-color); font-size: 2.5rem; font-weight: 700; margin: 0;">500+</h4>
                                <p style="color: var(--text-medium); margin: 0.5rem 0 0; font-weight: 600;">Dự án hoàn thành</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card" style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                                <h4 style="color: var(--secondary-color); font-size: 2.5rem; font-weight: 700; margin: 0;">15+</h4>
                                <p style="color: var(--text-medium); margin: 0.5rem 0 0; font-weight: 600;">Năm kinh nghiệm</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0" data-aos="fade-left">
                <div style="position: relative;">
                    <img src="{{ $settings['about_image_2']->value_vi ?? 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1200' }}"
                        alt="Modern Interior Design"
                        class="img-fluid shadow-custom hover-lift"
                        style="width: 100%; height: 500px; object-fit: cover; border-radius: 12px;">
                    <!-- Decorative Element -->
                    <div style="position: absolute; bottom: -20px; left: -20px; width: 150px; height: 150px; 
                                background: linear-gradient(135deg, var(--accent-gold), transparent); 
                                opacity: 0.3; border-radius: 50%; z-index: -1;"></div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1" data-aos="fade-right">
                <div style="padding-right: 2rem;">
                    <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                                 letter-spacing: 2px; font-size: 0.9rem;">Tầm nhìn & sứ mệnh</span>
                    <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; 
                               color: var(--primary-color); font-weight: 700; margin: 1rem 0 1.5rem; line-height: 1.2;">
                        Kiến tạo không gian sống hoàn hảo
                    </h3>
                    <div style="width: 60px; height: 3px; background: var(--secondary-color); margin-bottom: 2rem;"></div>
                    <p style="line-height: 1.9; color: var(--text-medium); text-align: justify; font-size: 1.05rem; margin-bottom: 2rem;">
                        Chúng tôi tin rằng mỗi không gian đều có câu chuyện riêng và tiềm năng để trở thành nơi đặc biệt.
                        Sứ mệnh của LUXUS là biến những ý tưởng thành hiện thực, tạo ra những không gian sống không chỉ
                        đẹp mắt mà còn mang đến cảm giác thoải mái và hạnh phúc cho người sử dụng.
                    </p>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-check-circle me-3" style="font-size: 1.5rem; color: var(--secondary-color); margin-top: 3px;"></i>
                        <div>
                            <h6 style="color: var(--primary-color); font-weight: 700; margin-bottom: 0.5rem;">Đổi mới sáng tạo</h6>
                            <p style="color: var(--text-medium); margin: 0;">Không ngừng cập nhật xu hướng thiết kế quốc tế</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-check-circle me-3" style="font-size: 1.5rem; color: var(--secondary-color); margin-top: 3px;"></i>
                        <div>
                            <h6 style="color: var(--primary-color); font-weight: 700; margin-bottom: 0.5rem;">Chất lượng tốt nhất</h6>
                            <p style="color: var(--text-medium); margin: 0;">Cam kết sử dụng vật liệu cao cấp và thi công chuyên nghiệp</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="fas fa-check-circle me-3" style="font-size: 1.5rem; color: var(--secondary-color); margin-top: 3px;"></i>
                        <div>
                            <h6 style="color: var(--primary-color); font-weight: 700; margin-bottom: 0.5rem;">Tận tâm với khách hàng</h6>
                            <p style="color: var(--text-medium); margin: 0;">Lắng nghe và thấu hiểu để tạo ra không gian hoàn hảo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Values - Enhanced -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                         letter-spacing: 2px; font-size: 0.9rem;">Những gì chúng tôi tin tưởng</span>
            <h2 class="section-title" style="margin-top: 1rem;">Giá trị cốt lõi</h2>
            <p class="section-subtitle" style="max-width: 700px; margin: 0 auto;">
                Các nguyên tắc định hình cách chúng tôi làm việc và tạo ra giá trị cho khách hàng
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h5 style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem;">Sáng tạo</h5>
                    <p style="font-style: italic; color: var(--text-light); margin-bottom: 1rem;">Creativity</p>
                    <p style="color: var(--text-medium); line-height: 1.8;">
                        Đổi mới không ngừng trong từng thiết kế, mang đến không gian độc đáo và ấn tượng
                        phản ánh cá tính riêng của từng khách hàng.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h5 style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem;">Chất lượng</h5>
                    <p style="font-style: italic; color: var(--text-light); margin-bottom: 1rem;">Quality</p>
                    <p style="color: var(--text-medium); line-height: 1.8;">
                        Cam kết chất lượng cao nhất trong mọi dự án, từ ý tưởng thiết kế đến thi công hoàn thiện,
                        sử dụng vật liệu cao cấp.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5 style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem;">Tận tâm</h5>
                    <p style="font-style: italic; color: var(--text-light); margin-bottom: 1rem;">Dedication</p>
                    <p style="color: var(--text-medium); line-height: 1.8;">
                        Luôn lắng nghe và thấu hiểu nhu cầu khách hàng, tạo ra không gian mơ ước
                        với sự tận tâm và chuyên nghiệp cao nhất.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h5 style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem;">Tin cậy</h5>
                    <p style="font-style: italic; color: var(--text-light); margin-bottom: 1rem;">Trust</p>
                    <p style="color: var(--text-medium); line-height: 1.8;">
                        Xây dựng mối quan hệ lâu dài với khách hàng dựa trên sự minh bạch,
                        trung thực và cam kết thực hiện đúng tiến độ.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h5 style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem;">Bền vững</h5>
                    <p style="font-style: italic; color: var(--text-light); margin-bottom: 1rem;">Sustainability</p>
                    <p style="color: var(--text-medium); line-height: 1.8;">
                        Ưu tiên sử dụng vật liệu thân thiện môi trường và thiết kế bền vững
                        cho tương lai xanh hơn.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h5 style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem;">Xuất sắc</h5>
                    <p style="font-style: italic; color: var(--text-light); margin-bottom: 1rem;">Excellence</p>
                    <p style="color: var(--text-medium); line-height: 1.8;">
                        Không ngừng nâng cao năng lực, cập nhật xu hướng để mang đến những
                        giải pháp thiết kế vượt trội.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline / Milestone Section -->
<section class="py-5" style="background: linear-gradient(to bottom, white, var(--accent-cream));">
    <div class="container">
        <div class="text-center mb-5">
            <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                         letter-spacing: 2px; font-size: 0.9rem;">Hành trình phát triển</span>
            <h2 class="section-title" style="margin-top: 1rem;">Các mốc quan trọng</h2>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                <div class="milestone-card">
                    <div class="milestone-year">2010</div>
                    <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1rem;">Khởi đầu</h5>
                    <p style="color: var(--text-medium); line-height: 1.7;">
                        LUXUS được thành lập tại Hà Nội với tầm nhìn mang đến không gian sống đẳng cấp
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="milestone-card">
                    <div class="milestone-year">2015</div>
                    <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1rem;">Mở rộng</h5>
                    <p style="color: var(--text-medium); line-height: 1.7;">
                        Hoàn thành 100+ dự án và mở rộng dịch vụ ra thị trường Đông Nam Á
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="milestone-card">
                    <div class="milestone-year">2020</div>
                    <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1rem;">Thành tựu</h5>
                    <p style="color: var(--text-medium); line-height: 1.7;">
                        Đạt 300+ dự án thành công và nhận nhiều giải thưởng thiết kế uy tín
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="milestone-card">
                    <div class="milestone-year">2025</div>
                    <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1rem;">Hiện tại</h5>
                    <p style="color: var(--text-medium); line-height: 1.7;">
                        500+ dự án hoàn thành và tiếp tục dẫn đầu xu hướng thiết kế nội thất
                    </p>
                </div>
            </div>
        </div>
    </div>
</section><!-- Team & Expertise Section - Enhanced -->
<section class="py-5" style="background-color: var(--accent-cream);">
    <div class="container">
        <div class="text-center mb-5">
            <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                         letter-spacing: 2px; font-size: 0.9rem;">Đội ngũ của chúng tôi</span>
            <h2 class="section-title" style="margin-top: 1rem;">Chuyên môn hàng đầu</h2>
            <p class="section-subtitle">
                Đội ngũ chuyên gia giàu kinh nghiệm, tận tâm và sáng tạo
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="0">
                <div class="expertise-item">
                    <div class="expertise-icon">
                        <i class="fas fa-drafting-compass"></i>
                    </div>
                    <h5 style="color: var(--primary-color); font-weight: 700; font-size: 1.3rem; margin-bottom: 0.8rem;">
                        Kiến trúc sư
                    </h5>
                    <p style="font-style: italic; color: var(--text-light); margin-bottom: 1rem; font-size: 0.95rem;">
                        Architects
                    </p>
                    <p style="color: var(--text-medium); line-height: 1.7;">
                        Đội ngũ kiến trúc sư giàu kinh nghiệm với hơn 10 năm trong ngành,
                        am hiểu sâu sắc về không gian và công năng
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="expertise-item">
                    <div class="expertise-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h5 style="color: var(--primary-color); font-weight: 700; font-size: 1.3rem; margin-bottom: 0.8rem;">
                        Thiết kế nội thất
                    </h5>
                    <p style="font-style: italic; color: var(--text-light); margin-bottom: 1rem; font-size: 0.95rem;">
                        Interior Designers
                    </p>
                    <p style="color: var(--text-medium); line-height: 1.7;">
                        Chuyên gia thiết kế nội thất cao cấp, am hiểu xu hướng quốc tế
                        và phong cách đa dạng
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="expertise-item">
                    <div class="expertise-icon">
                        <i class="fas fa-hard-hat"></i>
                    </div>
                    <h5 style="color: var(--primary-color); font-weight: 700; font-size: 1.3rem; margin-bottom: 0.8rem;">
                        Thi công
                    </h5>
                    <p style="font-style: italic; color: var(--text-light); margin-bottom: 1rem; font-size: 0.95rem;">
                        Construction Team
                    </p>
                    <p style="color: var(--text-medium); line-height: 1.7;">
                        Đội ngũ thi công chuyên nghiệp, tay nghề cao,
                        đảm bảo tiến độ và chất lượng hoàn hảo
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="expertise-item">
                    <div class="expertise-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h5 style="color: var(--primary-color); font-weight: 700; font-size: 1.3rem; margin-bottom: 0.8rem;">
                        Quản lý dự án
                    </h5>
                    <p style="font-style: italic; color: var(--text-light); margin-bottom: 1rem; font-size: 0.95rem;">
                        Project Management
                    </p>
                    <p style="color: var(--text-medium); line-height: 1.7;">
                        Đội ngũ quản lý dự án chuyên nghiệp,
                        giám sát chặt chẽ từng công đoạn thực hiện
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                             letter-spacing: 2px; font-size: 0.9rem;">Tại sao chọn chúng tôi</span>
                <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 2.8rem; 
                           color: var(--primary-color); font-weight: 700; margin: 1rem 0 2rem; line-height: 1.2;">
                    Những lý do khách hàng<br>tin tưởng LUXUS
                </h2>

                <div class="mb-4">
                    <div class="d-flex align-items-start">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--accent-gold), var(--secondary-color)); 
                                    border-radius: 50%; display: flex; align-items: center; justify-content: center; 
                                    flex-shrink: 0; margin-right: 1.5rem;">
                            <i class="fas fa-award" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                        <div>
                            <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 0.5rem;">
                                Kinh nghiệm 15+ năm
                            </h5>
                            <p style="color: var(--text-medium); line-height: 1.7; margin: 0;">
                                Với hơn 500 dự án hoàn thành thành công, chúng tôi hiểu rõ nhu cầu và mong muốn của khách hàng
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-start">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--accent-gold), var(--secondary-color)); 
                                    border-radius: 50%; display: flex; align-items: center; justify-content: center; 
                                    flex-shrink: 0; margin-right: 1.5rem;">
                            <i class="fas fa-shield-alt" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                        <div>
                            <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 0.5rem;">
                                Cam kết chất lượng
                            </h5>
                            <p style="color: var(--text-medium); line-height: 1.7; margin: 0;">
                                Bảo hành dài hạn, hỗ trợ sau bán hàng tận tâm, đảm bảo sự hài lòng tuyệt đối
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-start">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--accent-gold), var(--secondary-color)); 
                                    border-radius: 50%; display: flex; align-items: center; justify-content: center; 
                                    flex-shrink: 0; margin-right: 1.5rem;">
                            <i class="fas fa-clock" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                        <div>
                            <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 0.5rem;">
                                Đúng tiến độ
                            </h5>
                            <p style="color: var(--text-medium); line-height: 1.7; margin: 0;">
                                Quản lý dự án chuyên nghiệp, cam kết hoàn thành đúng thời gian đã thỏa thuận
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="d-flex align-items-start">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--accent-gold), var(--secondary-color)); 
                                    border-radius: 50%; display: flex; align-items: center; justify-content: center; 
                                    flex-shrink: 0; margin-right: 1.5rem;">
                            <i class="fas fa-dollar-sign" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                        <div>
                            <h5 style="color: var(--primary-color); font-weight: 700; margin-bottom: 0.5rem;">
                                Giá cả hợp lý
                            </h5>
                            <p style="color: var(--text-medium); line-height: 1.7; margin: 0;">
                                Chi phí minh bạch, tối ưu ngân sách mà vẫn đảm bảo chất lượng cao nhất
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="row g-3">
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=600"
                            alt="LUXUS Project 1"
                            class="img-fluid shadow-custom hover-lift"
                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 12px;">
                    </div>
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600"
                            alt="LUXUS Project 2"
                            class="img-fluid shadow-custom hover-lift"
                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 12px; margin-top: 2rem;">
                    </div>
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1600210492493-0946911123ea?w=600"
                            alt="LUXUS Project 3"
                            class="img-fluid shadow-custom hover-lift"
                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 12px; margin-top: -2rem;">
                    </div>
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=600"
                            alt="LUXUS Project 4"
                            class="img-fluid shadow-custom hover-lift"
                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 12px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section - Enhanced -->
<section class="py-5" style="background: linear-gradient(135deg, #2C2416 0%, #6B4423 50%, #8B6B47 100%); 
                                        position: relative; overflow: hidden;">
    <!-- Decorative Elements -->
    <div style="position: absolute; top: -80px; right: -80px; width: 300px; height: 300px; 
                background: radial-gradient(circle, rgba(212, 175, 55, 0.15), transparent); 
                border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -100px; left: -100px; width: 400px; height: 400px; 
                background: radial-gradient(circle, rgba(196, 168, 124, 0.1), transparent); 
                border-radius: 50%;"></div>

    <div class="container text-center text-white" style="position: relative; z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <i class="fas fa-comments mb-4" style="font-size: 4rem; color: var(--secondary-color);"></i>
                <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 3rem; font-weight: 700; 
                           margin-bottom: 1.5rem; line-height: 1.3;">
                    Sẵn sàng bắt đầu<br>dự án của bạn?
                </h2>
                <p style="font-size: 1.3rem; margin-bottom: 3rem; line-height: 1.7; opacity: 0.95;">
                    Hãy để chúng tôi biến ý tưởng của bạn thành hiện thực.<br>
                    Liên hệ ngay để nhận tư vấn miễn phí từ đội ngũ chuyên gia.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-lg"
                        style="background: white; color: var(--primary-color); padding: 15px 45px; 
                              font-weight: 700; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px;
                              box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3); transition: all 0.3s;">
                        <i class="fas fa-paper-plane me-2"></i>Liên hệ tư vấn
                    </a>
                    <a href="{{ route('projects.index') }}" class="btn btn-lg"
                        style="background: transparent; color: white; padding: 15px 45px; 
                              font-weight: 700; border-radius: 50px; text-transform: uppercase; 
                              letter-spacing: 1px; border: 2px solid white;
                              box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3); transition: all 0.3s;">
                        <i class="fas fa-th me-2"></i>Xem dự án
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Add hover effects to CTA buttons
    document.querySelectorAll('section a.btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 12px 40px rgba(0, 0, 0, 0.4)';
        });
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 8px 30px rgba(0, 0, 0, 0.3)';
        });
    });
</script>
@endpush

@endsection