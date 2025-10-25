@extends('admin.layouts.app')

@section('title', 'Quản lý Báo giá')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-file-invoice text-primary me-2"></i> Yêu cầu Báo giá</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Báo giá</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-2"></i>Làm mới
            </button>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="card mb-4" style="border: none; box-shadow: 0 4px 15px rgba(139, 107, 71, 0.1);">
    <div class="card-body p-0">
        <ul class="nav nav-pills p-3" style="gap: 8px;">
            <li class="nav-item">
                <a class="nav-link {{ !request('status') ? 'active' : '' }}"
                    href="{{ route('admin.quotes.index') }}">
                    <i class="fas fa-list me-1"></i> Tất cả
                    <span class="badge {{ !request('status') ? 'bg-light text-dark' : 'bg-secondary' }} ms-1">{{ $statusCounts['all'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'pending' ? 'active status-pending' : '' }}"
                    href="{{ route('admin.quotes.index', ['status' => 'pending']) }}">
                    <i class="fas fa-clock me-1"></i> Chờ xử lý
                    <span class="badge {{ request('status') === 'pending' ? 'bg-light text-dark' : 'bg-warning' }} ms-1">{{ $statusCounts['pending'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'reviewing' ? 'active status-reviewing' : '' }}"
                    href="{{ route('admin.quotes.index', ['status' => 'reviewing']) }}">
                    <i class="fas fa-eye me-1"></i> Đang xem xét
                    <span class="badge {{ request('status') === 'reviewing' ? 'bg-light text-dark' : 'bg-info' }} ms-1">{{ $statusCounts['reviewing'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'quoted' ? 'active status-quoted' : '' }}"
                    href="{{ route('admin.quotes.index', ['status' => 'quoted']) }}">
                    <i class="fas fa-check-circle me-1"></i> Đã báo giá
                    <span class="badge {{ request('status') === 'quoted' ? 'bg-light text-dark' : 'bg-primary' }} ms-1">{{ $statusCounts['quoted'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'accepted' ? 'active status-accepted' : '' }}"
                    href="{{ route('admin.quotes.index', ['status' => 'accepted']) }}">
                    <i class="fas fa-handshake me-1"></i> Đã chấp nhận
                    <span class="badge {{ request('status') === 'accepted' ? 'bg-light text-dark' : 'bg-success' }} ms-1">{{ $statusCounts['accepted'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'rejected' ? 'active status-rejected' : '' }}"
                    href="{{ route('admin.quotes.index', ['status' => 'rejected']) }}">
                    <i class="fas fa-times-circle me-1"></i> Đã từ chối
                    <span class="badge {{ request('status') === 'rejected' ? 'bg-light text-dark' : 'bg-danger' }} ms-1">{{ $statusCounts['rejected'] }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="data-table">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 20%"><i class="fas fa-user me-2"></i>Khách hàng</th>
                    <th style="width: 20%"><i class="fas fa-address-book me-2"></i>Liên hệ</th>
                    <th style="width: 12%"><i class="fas fa-building me-2"></i>Loại dự án</th>
                    <th style="width: 12%"><i class="fas fa-money-bill-wave me-2"></i>Ngân sách</th>
                    <th style="width: 12%"><i class="fas fa-dollar-sign me-2"></i>Báo giá</th>
                    <th style="width: 10%"><i class="fas fa-info-circle me-2"></i>Trạng thái</th>
                    <th style="width: 12%"><i class="fas fa-calendar me-2"></i>Ngày tạo</th>
                    <th style="width: 7%" class="text-center"><i class="fas fa-cog"></i></th>
                </tr>
            </thead>
            <tbody>
                @forelse($quotes as $quote)
                <tr>
                    <td class="fw-bold text-muted" data-label="#">{{ $quote->id }}</td>
                    <td data-label="Khách hàng">
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle me-2"
                                style="width: 40px; height: 40px; border-radius: 50%; 
                                        background: linear-gradient(135deg, #8B6B47 0%, #D4AF37 100%); 
                                        color: white; display: flex; align-items: center; 
                                        justify-content: center; font-weight: bold; font-size: 0.9rem;">
                                {{ substr($quote->client_name ?? 'N', 0, 1) }}
                            </div>
                            <div>
                                <strong class="d-block">{{ $quote->client_name ?? 'N/A' }}</strong>
                                @if($quote->reference_project)
                                <small class="text-muted">
                                    <i class="fas fa-project-diagram me-1"></i>{{ Str::limit($quote->reference_project, 20) }}
                                </small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td data-label="Liên hệ">
                        <div class="small">
                            <div class="mb-1">
                                <i class="fas fa-envelope text-primary me-1"></i>
                                <a href="mailto:{{ $quote->client_email }}" class="text-decoration-none">
                                    {{ Str::limit($quote->client_email ?? 'N/A', 25) }}
                                </a>
                            </div>
                            <div>
                                <i class="fas fa-phone text-success me-1"></i>
                                <a href="tel:{{ $quote->client_phone }}" class="text-decoration-none">
                                    {{ $quote->client_phone ?? 'N/A' }}
                                </a>
                            </div>
                        </div>
                    </td>
                    <td data-label="Loại dự án">
                        @php
                        $projectTypes = [
                        'housing' => ['icon' => 'home', 'text' => 'Nhà ở', 'color' => '#3498db'],
                        'apartment' => ['icon' => 'building', 'text' => 'Căn hộ', 'color' => '#9b59b6'],
                        'office' => ['icon' => 'briefcase', 'text' => 'Văn phòng', 'color' => '#e74c3c'],
                        'commercial' => ['icon' => 'store', 'text' => 'Thương mại', 'color' => '#f39c12'],
                        ];
                        $type = $projectTypes[$quote->project_type] ?? ['icon' => 'question', 'text' => $quote->project_type ?? 'N/A', 'color' => '#95a5a6'];
                        @endphp
                        <span class="badge project-type-badge" data-color="{{ $type['color'] }}">
                            <i class="fas fa-{{ $type['icon'] }} me-1"></i>{{ $type['text'] }}
                        </span>
                    </td>
                    <td data-label="Ngân sách">
                        @if($quote->budget)
                        <strong class="text-dark">{{ number_format($quote->budget, 0, ',', '.') }}</strong>
                        <small class="text-muted d-block">VNĐ</small>
                        @if($quote->area)
                        <small class="text-muted">
                            <i class="fas fa-ruler-combined me-1"></i>{{ number_format($quote->area, 0) }}m²
                        </small>
                        @endif
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td data-label="Báo giá">
                        @if($quote->quoted_amount)
                        <strong class="text-primary" style="font-size: 1.05rem;">
                            {{ number_format($quote->quoted_amount, 0, ',', '.') }}
                        </strong>
                        <small class="text-muted d-block">VNĐ</small>
                        @else
                        <span class="text-muted">Chưa báo giá</span>
                        @endif
                    </td>
                    <td data-label="Trạng thái">
                        @if($quote->status === 'pending')
                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Chờ xử lý</span>
                        @elseif($quote->status === 'reviewing')
                        <span class="badge bg-info"><i class="fas fa-eye me-1"></i>Xem xét</span>
                        @elseif($quote->status === 'quoted')
                        <span class="badge bg-primary"><i class="fas fa-check-circle me-1"></i>Đã báo giá</span>
                        @elseif($quote->status === 'accepted')
                        <span class="badge bg-success"><i class="fas fa-handshake me-1"></i>Chấp nhận</span>
                        @elseif($quote->status === 'rejected')
                        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Từ chối</span>
                        @endif
                    </td>
                    <td data-label="Ngày tạo">
                        <div class="small">
                            <i class="fas fa-calendar-alt text-muted me-1"></i>{{ $quote->created_at->format('d/m/Y') }}
                            <div class="text-muted">
                                <i class="far fa-clock me-1"></i>{{ $quote->created_at->format('H:i') }}
                            </div>
                        </div>
                    </td>
                    <td class="text-center" data-label="Hành động">
                        <a href="{{ route('admin.quotes.show', $quote) }}"
                            class="btn btn-sm btn-primary-custom"
                            title="Xem chi tiết"
                            style="padding: 8px 16px;">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                            <h5>Không có yêu cầu báo giá nào</h5>
                            <p class="mb-0">Danh sách trống. Yêu cầu báo giá từ khách hàng sẽ hiển thị tại đây.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($quotes->hasPages())
    <div class="card-footer bg-white border-top-0">
        <div class="text-muted small mb-2">
            Hiển thị <strong>{{ $quotes->firstItem() ?? 0 }} - {{ $quotes->lastItem() ?? 0 }}</strong>
            trong tổng số <strong>{{ $quotes->total() }}</strong> yêu cầu
        </div>
        {{ $quotes->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* ẨNHOÀN TOÀN SCROLLBAR */
    * {
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE/Edge */
    }

    *::-webkit-scrollbar {
        display: none;
        /* Chrome/Safari/Opera */
        width: 0;
        height: 0;
    }

    html,
    body {
        overflow-x: hidden;
        overflow-y: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    html::-webkit-scrollbar,
    body::-webkit-scrollbar {
        display: none;
        width: 0;
        height: 0;
    }

    .data-table {
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .data-table::-webkit-scrollbar {
        display: none;
        width: 0;
        height: 0;
    }

    /* Reserve space at bottom to prevent scrollbar flickering */
    .card {
        margin-bottom: 30px;
        max-width: 100%;
        overflow: hidden;
    }

    .card-body {
        overflow-x: auto;
        max-width: 100%;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .card-body::-webkit-scrollbar {
        display: none;
    }

    .pagination-container {
        padding: 20px 0 40px 0;
        max-width: 100%;
        overflow: hidden;
    }

    .table {
        max-width: 100%;
        table-layout: fixed;
    }

    /* Compact table rows to reduce height */
    .table td,
    .table th {
        padding: 8px !important;
        font-size: 14px;
        line-height: 1.3;
    }

    .table tbody tr {
        height: auto;
    }

    /* Compact avatar */
    .avatar-circle {
        width: 32px !important;
        height: 32px !important;
        font-size: 12px;
    }

    /* Compact badges */
    .badge {
        padding: 4px 8px;
        font-size: 11px;
    }

    /* Nav Pills */
    .nav-pills .nav-link {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s ease;
        border: 2px solid transparent;
        color: #8B6B47;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #8B6B47 0%, #D4AF37 100%);
        color: white;
    }

    .nav-pills .nav-link.active.status-pending {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #000;
    }

    .nav-pills .nav-link.active.status-reviewing {
        background: linear-gradient(135deg, #17a2b8 0%, #0d8fa8 100%);
        color: white;
    }

    .nav-pills .nav-link.active.status-quoted {
        background: linear-gradient(135deg, #8B6B47 0%, #D4AF37 100%);
        color: white;
    }

    .nav-pills .nav-link.active.status-accepted {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }

    .nav-pills .nav-link.active.status-rejected {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    .nav-pills .nav-link:not(.active):hover {
        background-color: rgba(139, 107, 71, 0.1);
        border-color: #8B6B47;
    }

    /* Avatar */
    .avatar-circle {
        box-shadow: 0 2px 8px rgba(139, 107, 71, 0.3);
    }

    /* Project Type Badge */
    .project-type-badge {
        font-size: 0.85rem;
    }

    /* Table Row Hover */
    .table-hover tbody tr {
        transition: background-color 0.2s ease;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(139, 107, 71, 0.05);
    }

    /* Status Badges Animation */
    .badge {
        animation: fadeInScale 0.5s ease-out;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.8);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Pagination Container */
    .pagination-container {
        padding: 15px 0;
        max-width: 100%;
    }

    /* Ultra Simple Pagination - NO HOVER EFFECTS */
    ul.pagination {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        margin: 0 auto;
        gap: 6px;
        justify-content: center;
        max-width: fit-content;
    }

    ul.pagination li {
        display: inline-block;
        margin: 0;
    }

    ul.pagination li a,
    ul.pagination li span {
        display: block;
        width: 38px;
        height: 38px;
        line-height: 34px;
        padding: 0;
        border: 2px solid #dee2e6;
        border-radius: 6px;
        background: #fff;
        color: #8B6B47;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        text-align: center;
        cursor: default;
    }

    ul.pagination li a {
        cursor: pointer;
    }

    ul.pagination li.active span {
        background: #8B6B47;
        color: #fff;
        border-color: #8B6B47;
    }

    ul.pagination li.disabled span {
        background: #f8f9fa;
        color: #999;
        cursor: not-allowed;
        opacity: 0.5;
    }

    /* MOBILE RESPONSIVE */
    @media (max-width: 768px) {

        /* Page Header */
        .page-header .d-flex {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 15px;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .page-header .btn {
            width: 100%;
            justify-content: center;
        }

        /* Breadcrumb */
        .breadcrumb {
            font-size: 12px;
        }

        /* Nav Pills - Scrollable */
        .nav-pills {
            flex-wrap: nowrap !important;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: 12px !important;
        }

        .nav-pills::-webkit-scrollbar {
            display: none;
        }

        .nav-pills .nav-link {
            white-space: nowrap;
            font-size: 11px;
            padding: 8px 12px !important;
            min-width: fit-content;
        }

        .nav-pills .badge {
            font-size: 9px;
            padding: 2px 6px;
        }

        /* Table to Card Layout */
        .data-table {
            overflow: visible;
        }

        .table-responsive {
            border: none;
            overflow: visible;
        }

        .table {
            border: none;
        }

        .table thead {
            display: none;
        }

        .table tbody {
            display: block;
        }

        .table tbody tr {
            display: block;
            margin-bottom: 20px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px;
            background: #fff;
            box-shadow: 0 2px 12px rgba(139, 107, 71, 0.08);
            position: relative;
        }

        .table tbody td {
            display: block;
            width: 100% !important;
            text-align: left !important;
            padding: 10px 0 !important;
            border: none;
            position: relative;
        }

        .table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            display: block;
            margin-bottom: 6px;
            color: #8B6B47;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* First column (ID) - Badge style */
        .table tbody td:first-child {
            position: absolute;
            top: 15px;
            right: 15px;
            width: auto !important;
            padding: 0 !important;
        }

        .table tbody td:first-child::before {
            display: none;
        }

        .table tbody td:first-child .fw-bold {
            background: #8B6B47;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        /* Avatar larger on mobile */
        .avatar-circle {
            width: 45px !important;
            height: 45px !important;
            font-size: 16px !important;
        }

        /* Badges larger on mobile */
        .badge {
            padding: 8px 14px !important;
            font-size: 13px !important;
            display: inline-block;
        }

        /* Project type badge */
        .project-type-badge {
            font-size: 13px !important;
        }

        /* Contact info */
        .table tbody td[data-label="Liên hệ"] .small {
            font-size: 14px !important;
        }

        /* Button full width on mobile */
        .table tbody td[data-label="Hành động"] {
            padding-top: 15px !important;
            border-top: 2px solid #f8f9fa;
            margin-top: 10px;
        }

        .table tbody td[data-label="Hành động"] .btn {
            width: 100% !important;
            padding: 12px !important;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .table tbody td[data-label="Hành động"] .btn i {
            font-size: 16px;
        }

        /* Empty state */
        .table tbody tr td[colspan] {
            border: none;
            padding: 40px 20px !important;
        }

        /* Pagination */
        .card-footer {
            padding: 15px !important;
        }

        ul.pagination {
            gap: 4px;
        }

        ul.pagination li a,
        ul.pagination li span {
            width: 32px;
            height: 32px;
            line-height: 28px;
            font-size: 12px;
        }

        /* Card spacing */
        .card {
            margin-bottom: 20px;
            border-radius: 12px;
        }

        .card-body {
            padding: 0 !important;
        }

        .data-table>.table-responsive {
            padding: 15px;
        }
    }

    /* Tablet */
    @media (max-width: 992px) and (min-width: 769px) {
        .page-header h1 {
            font-size: 1.75rem;
        }

        .nav-pills .nav-link {
            font-size: 12px;
        }

        .table td,
        .table th {
            font-size: 13px;
            padding: 6px !important;
        }
    }

    /* Small mobile */
    @media (max-width: 480px) {
        .page-header h1 {
            font-size: 1.25rem;
        }

        .page-header h1 i {
            display: none;
        }

        .nav-pills .nav-link {
            font-size: 10px;
            padding: 6px 10px !important;
        }

        .table tbody tr {
            padding: 12px;
        }

        ul.pagination li a,
        ul.pagination li span {
            width: 28px;
            height: 28px;
            line-height: 24px;
            font-size: 11px;
            border-width: 1px;
        }
    }
</style>

<script>
    // Set background colors for project type badges dynamically
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.project-type-badge').forEach(function(badge) {
            const color = badge.getAttribute('data-color');
            if (color) {
                badge.style.backgroundColor = color;
            }
        });
    });
</script>
@endpush