@extends('layouts.app')

@section('title', $project->title_vi . ' - LUXUS')

@push('styles')
<style>
    .project-detail-hero {
        position: relative;
        height: 600px;
        overflow: hidden;
    }

    .project-detail-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .project-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
        display: flex;
        align-items: flex-end;
    }

    .project-hero-content {
        width: 100%;
        padding: 3rem 0;
        color: white;
    }

    .project-hero-content h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .project-hero-content .subtitle {
        font-size: 1.3rem;
        opacity: 0.95;
        margin-bottom: 1.5rem;
    }

    .project-badge-hero {
        display: inline-block;
        padding: 0.6rem 1.5rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        color: var(--text-dark);
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .project-badge-hero i {
        color: var(--secondary-color);
        margin-right: 0.5rem;
    }

    .breadcrumb-project {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        display: inline-flex;
        margin-bottom: 1.5rem;
    }

    .breadcrumb-project a {
        color: white;
        text-decoration: none;
        margin: 0 0.5rem;
    }

    .breadcrumb-project a:hover {
        color: var(--secondary-color);
    }

    .project-info-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .project-info-item {
        padding: 1rem 0;
        border-bottom: 1px solid #F0F0F0;
    }

    .project-info-item:last-child {
        border-bottom: none;
    }

    .project-info-item strong {
        color: var(--primary-color);
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .project-info-item p {
        color: var(--text-dark);
        font-size: 1.1rem;
        margin: 0;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .gallery-item {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .gallery-item img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(139, 107, 71, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-overlay i {
        font-size: 3rem;
        color: white;
    }

    .quote-form-card {
        position: sticky;
        top: 90px;
        background: linear-gradient(135deg, #FAF7F2 0%, white 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        border: 2px solid var(--accent-gold);
    }

    .quote-form-card h5 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
    }

    .contact-info-box {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        margin-top: 1.5rem;
        border: 1px solid #E5E5E5;
    }

    .contact-info-box strong {
        display: block;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }

    .contact-info-box p {
        margin: 0.5rem 0;
        color: var(--text-dark);
    }

    .share-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin-top: 1.5rem;
    }

    .share-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 0.3rem;
        transition: all 0.3s ease;
    }

    .share-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .related-section {
        background: linear-gradient(to bottom, white 0%, #FAF7F2 100%);
        padding: 5rem 0;
    }

    @media (max-width: 768px) {
        .project-detail-hero {
            height: 400px;
        }

        .project-hero-content h1 {
            font-size: 2rem;
        }

        .gallery-grid {
            grid-template-columns: 1fr;
        }

        .quote-form-card {
            position: relative;
            top: 0;
        }
    }
</style>
@endpush

@section('content')
<!-- Project Hero -->
@php
$heroImage = $project->primaryImage ? $project->primaryImage->cloudinary_url : 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=1920';
@endphp
<div class="project-detail-hero">
    <img src="{{ $heroImage }}" alt="{{ $project->title_vi }}">
    <div class="project-hero-overlay">
        <div class="container">
            <div class="project-hero-content">
                <div class="breadcrumb-project">
                    <a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
                    <span>/</span>
                    <a href="{{ route('projects.index') }}">Dự án</a>
                    <span>/</span>
                    <a href="{{ route('projects.category', $project->category->slug) }}">{{ $project->category->name_vi }}</a>
                </div>

                <h1>{{ $project->title_vi }}</h1>
                @if($project->title_en)
                <p class="subtitle">{{ $project->title_en }}</p>
                @endif

                <div class="mt-3">
                    <span class="project-badge-hero">
                        <i class="fas fa-folder"></i>{{ $project->category->name_vi }}
                    </span>
                    <span class="project-badge-hero">
                        <i class="fas fa-map-marker-alt"></i>{{ $project->location }}
                    </span>
                    @if($project->year)
                    <span class="project-badge-hero">
                        <i class="fas fa-calendar"></i>{{ $project->year }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Project Details -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mb-4">
                <!-- Project Info -->
                <div class="project-info-card">
                    <h3 class="section-title" style="margin-bottom: 2rem;">
                        <i class="fas fa-info-circle me-2"></i>Thông tin dự án
                    </h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="project-info-item">
                                <strong><i class="fas fa-user me-2"></i>Khách hàng</strong>
                                <p>{{ $project->client_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-info-item">
                                <strong><i class="fas fa-map-marker-alt me-2"></i>Địa điểm</strong>
                                <p>{{ $project->location }}</p>
                            </div>
                        </div>
                        @if($project->area)
                        <div class="col-md-6">
                            <div class="project-info-item">
                                <strong><i class="fas fa-ruler-combined me-2"></i>Diện tích</strong>
                                <p>{{ number_format($project->area) }} m²</p>
                            </div>
                        </div>
                        @endif
                        @if($project->year)
                        <div class="col-md-6">
                            <div class="project-info-item">
                                <strong><i class="fas fa-calendar me-2"></i>Năm thực hiện</strong>
                                <p>{{ $project->year }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="project-info-item">
                                <strong><i class="fas fa-folder me-2"></i>Danh mục</strong>
                                <p>
                                    <a href="{{ route('projects.category', $project->category->slug) }}"
                                        class="text-primary-custom">
                                        {{ $project->category->name_vi }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-info-item">
                                <strong><i class="fas fa-tasks me-2"></i>Trạng thái</strong>
                                <p>
                                    @php
                                    $statusLabels = [
                                    'planning' => 'Lên kế hoạch',
                                    'ongoing' => 'Đang thực hiện',
                                    'completed' => 'Hoàn thành'
                                    ];
                                    @endphp
                                    <span class="badge bg-success">
                                        {{ $statusLabels[$project->status] ?? $project->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Description -->
                <div class="project-info-card">
                    <h3 class="section-title" style="margin-bottom: 1.5rem;">
                        <i class="fas fa-align-left me-2"></i>Mô tả dự án
                    </h3>
                    <p class="lead" style="font-size: 1.2rem; line-height: 1.8; color: var(--text-secondary);">
                        {{ $project->description_vi }}
                    </p>

                    @if($project->content_vi)
                    <div class="mt-4" style="line-height: 2; color: var(--text-dark);">
                        {!! nl2br(e($project->content_vi)) !!}
                    </div>
                    @endif

                    @if($project->description_en || $project->content_en)
                    <hr class="my-4" style="border-color: var(--accent-gold);">
                    <h5 style="color: var(--primary-color); font-family: 'Cormorant Garamond', serif; font-size: 1.5rem;">
                        <i class="fas fa-globe me-2"></i>Project Description (English)
                    </h5>
                    @if($project->description_en)
                    <p class="lead" style="font-size: 1.1rem; line-height: 1.8; color: #666; font-style: italic;">
                        {{ $project->description_en }}
                    </p>
                    @endif
                    @if($project->content_en)
                    <div class="mt-3" style="line-height: 1.9; font-style: italic; color: #666;">
                        {!! nl2br(e($project->content_en)) !!}
                    </div>
                    @endif
                    @endif
                </div>

                <!-- Project Images Gallery -->
                @if($project->images && $project->images->count() > 0)
                <div class="project-info-card">
                    <h3 class="section-title" style="margin-bottom: 1.5rem;">
                        <i class="fas fa-images me-2"></i>Thư viện ảnh
                    </h3>
                    <p class="text-muted mb-4">Nhấp vào ảnh để xem kích thước đầy đủ</p>

                    <div class="gallery-grid">
                        @foreach($project->images->sortBy('display_order') as $image)
                        <div class="gallery-item" onclick="openImageModal('{{ $image->cloudinary_url }}', '{{ $image->alt_text_vi }}')">
                            <img src="{{ $image->cloudinary_url }}"
                                alt="{{ $image->alt_text_vi }}">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                            @if($image->is_primary)
                            <div class="project-badge" style="position: absolute; top: 15px; left: 15px;">
                                <i class="fas fa-star"></i> Primary
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quote Form -->
                <div class="quote-form-card">
                    <h5>
                        <i class="fas fa-envelope-open-text me-2"></i>Quan tâm đến dự án này?
                    </h5>
                    <p class="text-muted mb-4">Để lại thông tin, chúng tôi sẽ liên hệ tư vấn miễn phí</p>

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

                    <form action="{{ route('quote.store') }}" method="POST" id="quoteForm">
                        @csrf
                        <input type="hidden" name="project_type" value="{{ $project->category->slug }}">
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="reference_project" value="{{ $project->title_vi }}">

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-user me-2"></i>Họ tên *</label>
                            <input type="text" name="client_name" class="form-control" required
                                placeholder="Nhập họ tên của bạn">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-envelope me-2"></i>Email *</label>
                            <input type="email" name="client_email" class="form-control" required
                                placeholder="email@example.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-phone me-2"></i>Số điện thoại *</label>
                            <input type="tel" name="client_phone" class="form-control" required
                                placeholder="0912 345 678">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-ruler-combined me-2"></i>Diện tích (m²)</label>
                            <input type="number" name="area" class="form-control" step="0.01"
                                placeholder="VD: 100">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-wallet me-2"></i>Ngân sách dự kiến</label>
                            <input type="number" name="budget" class="form-control" step="1000000"
                                placeholder="VD: 500000000">
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-comment-dots me-2"></i>Yêu cầu chi tiết</label>
                            <textarea name="request_details" class="form-control" rows="3"
                                placeholder="Mô tả chi tiết về dự án bạn muốn thực hiện..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100" id="submitBtn">
                            <i class="fas fa-paper-plane me-2"></i>Gửi yêu cầu báo giá
                        </button>
                    </form>

                    <div class="contact-info-box">
                        <strong><i class="fas fa-headset me-2"></i>Hoặc liên hệ trực tiếp</strong>
                        <p><i class="fas fa-phone me-2"></i>+84 123 456 789</p>
                        <p><i class="fas fa-envelope me-2"></i>contact@luxus.com</p>
                        <p><i class="fab fa-weixin me-2"></i>luxus_design</p>
                    </div>
                </div>

                <!-- Share Card -->
                <div class="share-card">
                    <h6 style="color: var(--primary-color); font-weight: 600; margin-bottom: 1rem;">
                        <i class="fas fa-share-alt me-2"></i>Chia sẻ dự án
                    </h6>
                    <div class="d-flex justify-content-center">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('projects.show', $project->slug)) }}"
                            target="_blank"
                            class="share-btn btn btn-outline-primary">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('projects.show', $project->slug)) }}&text={{ urlencode($project->title_vi) }}"
                            target="_blank"
                            class="share-btn btn btn-outline-info">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(route('projects.show', $project->slug)) }}&title={{ urlencode($project->title_vi) }}"
                            target="_blank"
                            class="share-btn btn btn-outline-primary">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <button type="button" class="share-btn btn btn-outline-secondary copy-link-btn"
                            data-url="{{ route('projects.show', $project->slug) }}"
                            title="Copy link">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Projects -->
@if($relatedProjects && $relatedProjects->count() > 0)
<section class="related-section">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="section-title">Dự án liên quan</h3>
            <p class="section-subtitle">Khám phá thêm các dự án tương tự</p>
        </div>

        <div class="row g-4">
            @foreach($relatedProjects->take(3) as $related)
            @if($related->id != $project->id)
            <div class="col-lg-4 col-md-6">
                <div class="project-card">
                    <div class="project-card-image">
                        @if($related->primary_image)
                        <img src="{{ $related->primary_image->cloudinary_url }}"
                            alt="{{ $related->title_vi }}">
                        @else
                        <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=800"
                            alt="{{ $related->title_vi }}">
                        @endif

                        <div class="project-card-overlay">
                            <a href="{{ route('projects.show', $related->slug) }}" class="btn btn-light">
                                <i class="fas fa-arrow-right"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>

                    <div class="project-card-body">
                        <div class="project-category">
                            <i class="fas fa-folder"></i> {{ $related->category->name_vi }}
                        </div>

                        <h3 class="project-title">
                            <a href="{{ route('projects.show', $related->slug) }}">{{ $related->title_vi }}</a>
                        </h3>

                        <div class="project-meta">
                            <span><i class="fas fa-map-marker-alt"></i> {{ $related->location }}</span>
                            @if($related->area)
                            <span><i class="fas fa-ruler-combined"></i> {{ number_format($related->area) }} m²</span>
                            @endif
                        </div>

                        <p class="project-description">{{ Str::limit($related->description_vi, 100) }}</p>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('projects.category', $project->category->slug) }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-th me-2"></i>Xem tất cả {{ $project->category->name_vi }}
            </a>
        </div>
    </div>
</section>
@endif

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="background: transparent; border: none;">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute"
                    style="top: 20px; right: 20px; z-index: 1051;"
                    data-bs-dismiss="modal"></button>
                <img id="modalImage" src="" alt="" class="img-fluid w-100" style="border-radius: 10px;">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image Modal
    function openImageModal(imageUrl, altText) {
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modalImage.alt = altText || '';
        modal.show();
    }

    // Copy to clipboard
    document.addEventListener('DOMContentLoaded', function() {
        // Copy link button
        const copyBtn = document.querySelector('.copy-link-btn');
        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                const btn = this;
                const originalHTML = btn.innerHTML;

                navigator.clipboard.writeText(url).then(function() {
                    btn.innerHTML = '<i class="fas fa-check"></i>';
                    btn.classList.add('btn-success');
                    btn.classList.remove('btn-outline-secondary');

                    setTimeout(function() {
                        btn.innerHTML = originalHTML;
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-outline-secondary');
                    }, 2000);
                }).catch(function(err) {
                    console.error('Failed to copy:', err);
                });
            });
        }

        // Form validation
        const quoteForm = document.getElementById('quoteForm');
        if (quoteForm) {
            quoteForm.addEventListener('submit', function() {
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi...';
                }
            });
        }

        // Auto-hide toasts after 5 seconds
        const toasts = document.querySelectorAll('.toast.show');
        toasts.forEach(toast => {
            setTimeout(() => {
                const bsToast = new bootstrap.Toast(toast);
                bsToast.hide();
            }, 5000);
        });
    });
</script>
@endpush