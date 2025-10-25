@extends('layouts.app')

@section('title', 'LUXUS - Thiết kế Nội thất Cao cấp | Luxury Interior Design')

@push('styles')
<style>
    /* Enhanced Hero Carousel */
    .hero-carousel {
        height: 100vh;
        min-height: 600px;
        position: relative;
        overflow: hidden;
    }

    .hero-carousel .carousel-item {
        height: 100vh;
        min-height: 600px;
        background-size: cover;
        background-position: center;
        position: relative;
        transition: transform 1.5s ease;
    }

    .hero-carousel .carousel-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(44, 36, 22, 0.75), rgba(107, 68, 35, 0.60));
        z-index: 1;
    }

    .hero-carousel .carousel-item::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
        z-index: 1;
    }

    .hero-carousel .carousel-caption {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        text-align: center;
        width: 90%;
        max-width: 1000px;
    }

    .hero-carousel .carousel-caption h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.8);
        letter-spacing: 10px;
        animation: fadeInDown 1s ease;
        line-height: 1.2;
        text-transform: uppercase;
    }

    .hero-carousel .carousel-caption p {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.5rem;
        font-weight: 300;
        margin-bottom: 2.5rem;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
        animation: fadeInUp 1s ease 0.3s both;
        letter-spacing: 3px;
    }

    .hero-carousel .carousel-caption .cta-buttons {
        animation: fadeInUp 1s ease 0.6s both;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-carousel .carousel-indicators {
        bottom: 40px;
        z-index: 3;
        margin: 0;
    }

    .hero-carousel .carousel-indicators button {
        width: 50px;
        height: 3px;
        border-radius: 2px;
        margin: 0 8px;
        background-color: rgba(255, 255, 255, 0.4);
        border: none;
        transition: all 0.3s;
    }

    .hero-carousel .carousel-indicators button.active {
        background-color: var(--secondary-color);
        width: 70px;
    }

    .hero-carousel .carousel-control-prev,
    .hero-carousel .carousel-control-next {
        z-index: 3;
        width: 80px;
        opacity: 0;
        transition: all 0.3s;
    }

    .hero-carousel:hover .carousel-control-prev,
    .hero-carousel:hover .carousel-control-next {
        opacity: 0.9;
    }

    .hero-carousel .carousel-control-prev:hover,
    .hero-carousel .carousel-control-next:hover {
        opacity: 1;
    }

    .hero-carousel .carousel-control-prev-icon,
    .hero-carousel .carousel-control-next-icon {
        background-size: 30px 30px;
        width: 50px;
        height: 50px;
        background-color: rgba(139, 107, 71, 0.8);
        border-radius: 50%;
    }

    /* Scroll Indicator */
    .scroll-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateX(-50%) translateY(0);
        }

        40% {
            transform: translateX(-50%) translateY(-10px);
        }

        60% {
            transform: translateX(-50%) translateY(-5px);
        }
    }

    @media (max-width: 992px) {
        .hero-carousel .carousel-caption h1 {
            font-size: 3.5rem;
            letter-spacing: 6px;
        }
    }

    @media (max-width: 768px) {
        .hero-carousel {
            height: 80vh;
            min-height: 500px;
        }

        .hero-carousel .carousel-item {
            height: 80vh;
            min-height: 500px;
        }

        .hero-carousel .carousel-caption h1 {
            font-size: 2.5rem;
            letter-spacing: 3px;
        }

        .hero-carousel .carousel-caption p {
            font-size: 1.1rem;
            letter-spacing: 1px;
        }

        .hero-carousel .carousel-control-prev,
        .hero-carousel .carousel-control-next {
            width: 50px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="false">
    @if($sliders->count() > 0)
    <div class="carousel-indicators">
        @foreach($sliders as $index => $slider)
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
            class="{{ $index == 0 ? 'active' : '' }}"
            aria-current="{{ $index == 0 ? 'true' : 'false' }}"
            aria-label="Slide {{ $index + 1 }}"></button>
        @endforeach
    </div>

    <div class="carousel-inner">
        @foreach($sliders as $index => $slider)
        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}"
            style="background-image: url('{{ $slider->cloudinary_url }}');">
            <div class="carousel-caption">
                <h1 class="text-white">LUXUS</h1>
                <p class="text-white">KIẾN TẠO KHÔNG GIAN VƯỢT TRỜI</p>
                <p class="text-white" style="font-size: 1.3rem; opacity: 0.95; font-style: italic; letter-spacing: 2px;">
                    Creating Spaces Beyond Imagination
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('projects.index') }}" class="btn btn-primary-custom btn-lg me-3"
                        style="font-size: 1rem; padding: 15px 45px; border-radius: 50px;">
                        <i class="fas fa-th me-2"></i>Khám phá Dự án
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-secondary-custom btn-lg"
                        style="font-size: 1rem; padding: 15px 45px; border-radius: 50px;">
                        <i class="fas fa-phone-alt me-2"></i>Liên hệ ngay
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    @else
    <!-- Fallback if no sliders -->
    <div class="carousel-inner">
        <div class="carousel-item active"
            style="background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=1920');">
            <div class="carousel-caption">
                <h1 class="text-white">LUXUS</h1>
                <p class="text-white">KIẾN TẠO KHÔNG GIAN VƯỢT TRỜI</p>
                <p class="text-white" style="font-size: 1.3rem; opacity: 0.95; font-style: italic; letter-spacing: 2px;">
                    Creating Spaces Beyond Imagination
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('projects.index') }}" class="btn btn-primary-custom btn-lg me-3"
                        style="font-size: 1rem; padding: 15px 45px;">
                        <i class="fas fa-th me-2"></i>Khám phá Dự án
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-secondary-custom btn-lg"
                        style="font-size: 1rem; padding: 15px 45px;">
                        <i class="fas fa-phone-alt me-2"></i>Liên hệ ngay
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Scroll Indicator -->
    <div class="scroll-indicator d-none d-md-block">
        <i class="fas fa-chevron-down" style="font-size: 2rem; color: white; opacity: 0.7;"></i>
    </div>
</div>

<!-- About Section - Enhanced -->
<section class="py-5" style="background-color: var(--accent-cream); position: relative; overflow: hidden;">
    <!-- Decorative Background Pattern -->
    <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; 
                background: linear-gradient(135deg, var(--accent-gold), transparent); 
                border-radius: 50%; opacity: 0.3; z-index: 0;"></div>
    <div style="position: absolute; bottom: -100px; left: -100px; width: 400px; height: 400px; 
                background: linear-gradient(135deg, transparent, var(--primary-light)); 
                border-radius: 50%; opacity: 0.2; z-index: 0;"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <div style="position: relative;">
                    <img src="https://images.unsplash.com/photo-1600210492493-0946911123ea?w=1200"
                        alt="LUXUS Interior Design"
                        class="img-fluid shadow-custom"
                        style="width: 100%; height: 500px; object-fit: cover; border-radius: 12px;">
                    <!-- Stats Overlay -->
                    <div class="position-absolute" style="bottom: -30px; right: 30px; background: white; 
                         padding: 2rem; border-radius: 12px; box-shadow: var(--shadow-xl); min-width: 250px;">
                        <div class="text-center">
                            <div class="stats-number" style="font-size: 2.5rem;">500+</div>
                            <div class="stats-label" style="font-size: 0.85rem;">Dự án hoàn thành</div>
                        </div>
                        <hr style="margin: 1rem 0; border-color: var(--accent-gold);">
                        <div class="text-center">
                            <div class="stats-number" style="font-size: 2.5rem;">15+</div>
                            <div class="stats-label" style="font-size: 0.85rem;">Năm kinh nghiệm</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div style="padding-left: 0; padding-right: 2rem;">
                    <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                                 letter-spacing: 2px; font-size: 0.9rem;">Về chúng tôi</span>
                    <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 3rem; 
                               color: var(--primary-color); font-weight: 700; margin: 1rem 0 1.5rem; line-height: 1.2;">
                        LUXUS - Kiến Tạo<br>Không Gian Vượt Trời
                    </h2>
                    <div style="width: 60px; height: 3px; background: var(--secondary-color); margin-bottom: 2rem;"></div>
                    <p class="lead" style="font-size: 1.15rem; color: var(--text-medium); line-height: 1.8; margin-bottom: 1.5rem;">
                        Chào mừng bạn đến với <strong style="color: var(--primary-color);">LUXUS</strong> – nơi bạn sẽ khám phá vẻ đẹp
                        và ý nghĩa của kiến trúc. Hơn thế nữa, đây cũng chính là điểm bắt đầu trong cuộc thám hiểm
                        tâm hồn và ý tưởng của bạn.
                    </p>
                    <p style="line-height: 1.8; color: var(--text-medium); margin-bottom: 2rem;">
                        <strong style="color: var(--primary-color);">LUXUS</strong> – đặt trụ sở tại Hà Nội, đã thực hiện
                        hàng trăm dự án kiến trúc và nội thất cho các khách hàng tại Việt Nam và Đông Nam Á.
                        Chúng tôi lấy tiêu chí về chất lượng cuộc sống, tinh thần, thẩm mỹ và công năng làm kim chỉ nam.
                        Sứ mệnh của chúng tôi là mang lại những trải nghiệm mới về <em>"Không Gian Sống"</em>.
                    </p>
                    <div class="row mb-4">
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3" style="font-size: 1.5rem; color: var(--secondary-color);"></i>
                                <span style="font-weight: 600; color: var(--text-dark);">Thiết kế độc đáo</span>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3" style="font-size: 1.5rem; color: var(--secondary-color);"></i>
                                <span style="font-weight: 600; color: var(--text-dark);">Chất lượng đảm bảo</span>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3" style="font-size: 1.5rem; color: var(--secondary-color);"></i>
                                <span style="font-weight: 600; color: var(--text-dark);">Thi công chuyên nghiệp</span>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3" style="font-size: 1.5rem; color: var(--secondary-color);"></i>
                                <span style="font-weight: 600; color: var(--text-dark);">Hỗ trợ tận tâm</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('about') }}" class="btn btn-primary-custom btn-lg">
                        <i class="fas fa-arrow-right me-2"></i>Tìm hiểu thêm
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section - Enhanced -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                         letter-spacing: 2px; font-size: 0.9rem;">Dịch vụ của chúng tôi</span>
            <h2 class="section-title">Danh mục dự án</h2>
            <p class="section-subtitle">
                Khám phá các lĩnh vực thiết kế nội thất chuyên nghiệp của LUXUS
            </p>
        </div>
        <div class="row g-4">
            @foreach($categories as $index => $category)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <a href="{{ route('projects.category', $category->slug) }}" style="text-decoration: none; color: inherit;">
                    <div class="category-card hover-lift">
                        @php
                        $categoryProject = \App\Models\Project::where('category_id', $category->id)
                        ->where('is_active', true)
                        ->whereHas('images')
                        ->with('images')
                        ->first();

                        $categoryImage = $categoryProject && $categoryProject->primary_image
                        ? $categoryProject->primary_image->cloudinary_url
                        : 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=800';
                        @endphp
                        <img src="{{ $categoryImage }}"
                            alt="{{ $category->name_vi }}"
                            style="transition: transform 0.5s ease;">
                        <div class="category-overlay">
                            <div style="transform: translateY(20px); transition: transform 0.3s;">
                                <h3 class="category-title">{{ $category->name_vi }}</h3>
                                <p style="font-style: italic; opacity: 0.9; margin-bottom: 1rem; font-size: 1.1rem;">
                                    {{ $category->name_en }}
                                </p>
                                <p class="mb-3" style="line-height: 1.6;">{{ $category->description_vi }}</p>
                                <div class="d-inline-flex align-items-center"
                                    style="color: var(--secondary-color); font-weight: 600;">
                                    Khám phá ngay <i class="fas fa-arrow-right ms-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section><!-- Featured Projects Section - Enhanced -->
<section class="py-5" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5">
            <span style="color: var(--secondary-color); font-weight: 600; text-transform: uppercase; 
                         letter-spacing: 2px; font-size: 0.9rem;">Portfolio</span>
            <h2 class="section-title">Dự án nổi bật</h2>
            <p class="section-subtitle">
                Những tác phẩm tiêu biểu thể hiện tầm nhìn và chuyên môn của chúng tôi
            </p>
        </div>
        <div class="row g-4">
            @forelse($featuredProjects as $index => $project)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="project-card hover-lift">
                    <div class="project-card-image">
                        @if($project->primaryImage)
                        <img src="{{ $project->primaryImage->cloudinary_url }}"
                            alt="{{ $project->title_vi }}"
                            loading="lazy">
                        @elseif($project->images && $project->images->isNotEmpty())
                        <img src="{{ $project->images->first()->cloudinary_url }}"
                            alt="{{ $project->title_vi }}"
                            loading="lazy">
                        @else
                        <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=800"
                            alt="{{ $project->title_vi }}"
                            loading="lazy">
                        @endif

                        <div class="project-card-overlay">
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-light">
                                <i class="fas fa-arrow-right"></i> Xem chi tiết
                            </a>
                        </div>

                        @if($project->is_featured)
                        <div class="project-badge featured">
                            <i class="fas fa-star"></i> Nổi bật
                        </div>
                        @endif

                        @php
                        $statusBadges = [
                        'planning' => ['class' => 'secondary', 'text' => 'Lên kế hoạch', 'icon' => 'fa-clock'],
                        'ongoing' => ['class' => 'info', 'text' => 'Đang thực hiện', 'icon' => 'fa-spinner'],
                        'completed' => ['class' => 'success', 'text' => 'Hoàn thành', 'icon' => 'fa-check-circle'],
                        ];
                        $badge = $statusBadges[$project->status] ?? ['class' => 'secondary', 'text' => $project->status, 'icon' => 'fa-info-circle'];
                        @endphp

                        <div class="project-badge status status-{{ $badge['class'] }}">
                            <i class="fas {{ $badge['icon'] }}"></i> {{ $badge['text'] }}
                        </div>
                    </div>

                    <div class="project-card-body">
                        <div class="project-category">
                            <i class="fas fa-folder"></i> {{ $project->category->name_vi }}
                        </div>

                        <h3 class="project-title">
                            <a href="{{ route('projects.show', $project->slug) }}">{{ $project->title_vi }}</a>
                        </h3>

                        <div class="project-meta">
                            <span><i class="fas fa-map-marker-alt"></i> {{ $project->location }}</span>
                            @if($project->area)
                            <span><i class="fas fa-ruler-combined"></i> {{ number_format($project->area) }} m²</span>
                            @endif
                            @if($project->year)
                            <span><i class="fas fa-calendar"></i> {{ $project->year }}</span>
                            @endif
                        </div>

                        <p class="project-description">{{ Str::limit($project->description_vi, 100) }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-folder-open" style="font-size: 5rem; color: var(--text-light); opacity: 0.3; margin-bottom: 2rem;"></i>
                    <h4 style="color: var(--text-medium);">Chưa có dự án nổi bật</h4>
                    <p style="color: var(--text-light);">Hãy quay lại sau để khám phá những dự án mới nhất của chúng tôi</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($featuredProjects->count() > 0)
        <div class="text-center mt-5">
            <a href="{{ route('projects.index') }}" class="btn btn-primary-custom btn-lg">
                <i class="fas fa-th me-2"></i>Xem tất cả dự án
            </a>
        </div>
        @endif
    </div>
</section>

<style>
    .project-card:hover .position-absolute.w-100 {
        opacity: 1 !important;
    }

    .project-card:hover img {
        transform: scale(1.05);
    }
</style>

<!-- Stats Section -->
<section class="py-5" style="background: linear-gradient(135deg, var(--primary-dark), var(--primary-color)); position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; 
                background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920'); 
                background-size: cover; background-position: center; opacity: 0.1;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row text-center text-white">
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <div class="counter-item">
                    <i class="fas fa-project-diagram mb-3" style="font-size: 3rem; color: var(--secondary-color);"></i>
                    <h3 class="counter" data-target="500" style="font-size: 3.5rem; font-weight: 700; margin-bottom: 0.5rem;">0</h3>
                    <p style="font-size: 1.1rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.9;">Dự án</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4 mb-md-0">
                <div class="counter-item">
                    <i class="fas fa-users mb-3" style="font-size: 3rem; color: var(--secondary-color);"></i>
                    <h3 class="counter" data-target="450" style="font-size: 3.5rem; font-weight: 700; margin-bottom: 0.5rem;">0</h3>
                    <p style="font-size: 1.1rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.9;">Khách hàng</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="counter-item">
                    <i class="fas fa-award mb-3" style="font-size: 3rem; color: var(--secondary-color);"></i>
                    <h3 class="counter" data-target="15" style="font-size: 3.5rem; font-weight: 700; margin-bottom: 0.5rem;">0</h3>
                    <p style="font-size: 1.1rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.9;">Năm kinh nghiệm</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="counter-item">
                    <i class="fas fa-smile mb-3" style="font-size: 3rem; color: var(--secondary-color);"></i>
                    <h3 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 0.5rem;">98%</h3>
                    <p style="font-size: 1.1rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.9;">Hài lòng</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA Section - Enhanced -->
<section class="py-5" style="background: linear-gradient(135deg, #2C2416 0%, #6B4423 50%, #8B6B47 100%); 
                                        position: relative; overflow: hidden;">
    <!-- Decorative Elements -->
    <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; 
                background: radial-gradient(circle, rgba(212, 175, 55, 0.2), transparent); 
                border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -150px; left: -150px; width: 500px; height: 500px; 
                background: radial-gradient(circle, rgba(196, 168, 124, 0.15), transparent); 
                border-radius: 50%;"></div>

    <div class="container text-center text-white" style="position: relative; z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <i class="fas fa-phone-volume mb-4" style="font-size: 4rem; color: var(--secondary-color);"></i>
                <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 3rem; font-weight: 700; 
                           margin-bottom: 1.5rem; line-height: 1.3;">
                    Bạn có dự án cần tư vấn?
                </h2>
                <p style="font-size: 1.3rem; margin-bottom: 3rem; line-height: 1.7; opacity: 0.95;">
                    Liên hệ với chúng tôi ngay hôm nay để nhận tư vấn miễn phí từ đội ngũ chuyên gia hàng đầu.
                    Chúng tôi sẵn sàng biến ý tưởng của bạn thành hiện thực.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('contact') }}" class="btn btn-lg"
                        style="background: white; color: var(--primary-color); padding: 15px 45px; 
                              font-weight: 700; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px;
                              box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);">
                        <i class="fas fa-paper-plane me-2"></i>Liên hệ ngay
                    </a>
                    <a href="tel:+84123456789" class="btn btn-lg"
                        style="background: linear-gradient(135deg, var(--secondary-color), #B8960A); 
                              color: white; padding: 15px 45px; font-weight: 700; border-radius: 50px;
                              text-transform: uppercase; letter-spacing: 1px; border: 2px solid white;
                              box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);">
                        <i class="fas fa-phone me-2"></i>+84 123 456 789
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Counter Animation
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += step;
            if (current < target) {
                element.textContent = Math.floor(current) + '+';
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target + '+';
            }
        };

        updateCounter();
    }

    // Trigger counter animation when section is in view
    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll('.counter');
                counters.forEach(counter => animateCounter(counter));
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const statsSection = document.querySelector('.counter-item')?.closest('section');
    if (statsSection) {
        observer.observe(statsSection);
    }
</script>
@endpush

@endsection