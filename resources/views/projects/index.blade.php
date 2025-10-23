@extends('layouts.app')

@section('title', isset($category) ? $category->name_vi . ' - Dự án' : 'Tất cả dự án - LUXUS')

@push('styles')
<style>
    .projects-hero {
        position: relative;
        height: 500px;
        background: linear-gradient(135deg, #8B6B47 0%, #6B4423 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .projects-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=1600');
        background-size: cover;
        background-position: center;
        opacity: 0.2;
    }

    .projects-hero-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
        max-width: 800px;
        padding: 0 20px;
    }

    .projects-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .projects-hero p {
        font-size: 1.2rem;
        opacity: 0.95;
        margin-bottom: 2rem;
    }

    .breadcrumb-custom {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        display: inline-flex;
        margin-bottom: 1rem;
    }

    .breadcrumb-custom a {
        color: white;
        text-decoration: none;
        margin: 0 0.5rem;
    }

    .breadcrumb-custom a:hover {
        color: var(--secondary-color);
    }

    .filter-section {
        background: linear-gradient(to bottom, #FAF7F2 0%, white 100%);
        padding: 3rem 0 2rem 0;
        border-bottom: 1px solid #E5E5E5;
    }

    .filter-btn {
        padding: 0.75rem 2rem;
        border-radius: 50px;
        border: 2px solid #E5E5E5;
        background: white;
        color: var(--text-dark);
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin: 0.5rem;
    }

    .filter-btn:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 107, 71, 0.2);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6B4423 100%);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 12px rgba(139, 107, 71, 0.3);
    }

    .projects-count {
        text-align: center;
        margin: 2rem 0;
        font-size: 1.1rem;
        color: var(--text-secondary);
    }

    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-state i {
        font-size: 5rem;
        color: #E5E5E5;
        margin-bottom: 2rem;
        display: block;
    }

    .empty-state h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .projects-hero h1 {
            font-size: 2.5rem;
        }

        .filter-btn {
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Projects Hero -->
<div class="projects-hero">
    <div class="projects-hero-content">
        <div class="breadcrumb-custom">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
            <span>/</span>
            <a href="{{ route('projects.index') }}">Dự án</a>
            @if(isset($category))
            <span>/</span>
            <span>{{ $category->name_vi }}</span>
            @endif
        </div>
        <h1>{{ isset($category) ? $category->name_vi : 'Tất cả dự án' }}</h1>
        @if(isset($category) && $category->description_vi)
        <p>{{ $category->description_vi }}</p>
        @else
        <p>Khám phá bộ sưu tập các dự án thiết kế nội thất đẳng cấp của LUXUS</p>
        @endif
    </div>
</div>

<!-- Category Filter Section -->
<div class="filter-section">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title" style="font-size: 2rem; margin-bottom: 0.5rem;">Danh mục dự án</h2>
            <p class="section-subtitle">Lọc theo từng loại hình thiết kế</p>
        </div>
        <div class="d-flex flex-wrap justify-content-center">
            <a href="{{ route('projects.index') }}"
                class="filter-btn {{ !isset($category) ? 'active' : '' }}">
                <i class="fas fa-th"></i> Tất cả
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('projects.category', $cat->slug) }}"
                class="filter-btn {{ isset($category) && $category->id == $cat->id ? 'active' : '' }}">
                {{ $cat->name_vi }}
            </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Projects Listing -->
<section class="py-5">
    <div class="container">
        <!-- Projects Count -->
        @if($projects->isNotEmpty())
        <div class="projects-count">
            <p>Hiển thị <strong>{{ method_exists($projects, 'total') ? $projects->total() : $projects->count() }}</strong> dự án {{ isset($category) ? 'trong danh mục "' . $category->name_vi . '"' : '' }}</p>
        </div>
        @endif

        <!-- Projects Grid -->
        <div class="row g-4">
            @forelse($projects as $project)
            <div class="col-lg-4 col-md-6">
                <div class="project-card">
                    <div class="project-card-image">
                        @if($project->primary_image)
                        <img src="{{ $project->primary_image->cloudinary_url }}"
                            alt="{{ $project->title_vi }}">
                        @else
                        <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=800"
                            alt="{{ $project->title_vi }}">
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
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h4>Chưa có dự án nào trong danh mục này</h4>
                    <p class="text-muted mb-4">Vui lòng chọn danh mục khác hoặc xem tất cả dự án</p>
                    @if(isset($category))
                    <a href="{{ route('projects.index') }}" class="btn btn-primary-custom">
                        <i class="fas fa-th"></i> Xem tất cả dự án
                    </a>
                    @endif
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($projects, 'hasPages') && $projects->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</section>
@endsection