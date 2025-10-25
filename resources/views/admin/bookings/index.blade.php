@extends('admin.layouts.app')

@section('title', 'Quản lý Lịch hẹn')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Lịch hẹn</h2>
</div>

<!-- Filter Tabs -->
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">
            Tất cả <span class="badge bg-secondary">{{ $statusCounts['all'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'pending' ? 'active' : '' }}"
            href="{{ route('admin.bookings.index', ['status' => 'pending']) }}">
            Chờ xác nhận <span class="badge bg-warning">{{ $statusCounts['pending'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'confirmed' ? 'active' : '' }}"
            href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}">
            Đã xác nhận <span class="badge bg-info">{{ $statusCounts['confirmed'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'completed' ? 'active' : '' }}"
            href="{{ route('admin.bookings.index', ['status' => 'completed']) }}">
            Hoàn thành <span class="badge bg-success">{{ $statusCounts['completed'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'cancelled' ? 'active' : '' }}"
            href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}">
            Đã hủy <span class="badge bg-danger">{{ $statusCounts['cancelled'] }}</span>
        </a>
    </li>
</ul>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Liên hệ</th>
                        <th>Ngày & Giờ hẹn</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th style="width: 100px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td data-label="Khách hàng">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-2"
                                    style="width: 40px; height: 40px; border-radius: 50%; 
                                            background: linear-gradient(135deg, #8B6B47 0%, #D4AF37 100%); 
                                            color: white; display: flex; align-items: center; 
                                            justify-content: center; font-weight: bold; font-size: 0.9rem;">
                                    {{ substr($booking->client_name ?? 'N', 0, 1) }}
                                </div>
                                <strong>{{ $booking->client_name ?? 'N/A' }}</strong>
                            </div>
                        </td>
                        <td data-label="Liên hệ">
                            <div class="small">
                                <div class="mb-1">
                                    <i class="fas fa-envelope text-primary me-1"></i>
                                    <a href="mailto:{{ $booking->client_email }}" class="text-decoration-none">
                                        {{ $booking->client_email ?? 'N/A' }}
                                    </a>
                                </div>
                                <div>
                                    <i class="fas fa-phone text-success me-1"></i>
                                    <a href="tel:{{ $booking->client_phone }}" class="text-decoration-none">
                                        {{ $booking->client_phone ?? 'N/A' }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td data-label="Ngày & Giờ hẹn">
                            <div class="small">
                                <div class="mb-1">
                                    <i class="fas fa-calendar text-primary me-1"></i>
                                    {{ \Carbon\Carbon::parse($booking->booking_time)->format('d/m/Y') }}
                                </div>
                                <div>
                                    <i class="fas fa-clock text-muted me-1"></i>
                                    {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                                </div>
                            </div>
                        </td>
                        <td data-label="Trạng thái">
                            @if($booking->status === 'pending')
                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Chờ xác nhận</span>
                            @elseif($booking->status === 'confirmed')
                            <span class="badge bg-info"><i class="fas fa-check-circle me-1"></i>Đã xác nhận</span>
                            @elseif($booking->status === 'completed')
                            <span class="badge bg-success"><i class="fas fa-check-double me-1"></i>Hoàn thành</span>
                            @elseif($booking->status === 'cancelled')
                            <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Đã hủy</span>
                            @endif
                        </td>
                        <td data-label="Ngày tạo">
                            <small class="text-muted">
                                <i class="far fa-calendar-plus me-1"></i>
                                {{ $booking->created_at->format('d/m/Y H:i') }}
                            </small>
                        </td>
                        <td class="text-center" data-label="Hành động">
                            <a href="{{ route('admin.bookings.show', $booking) }}"
                                class="btn btn-sm btn-primary-custom"
                                title="Xem chi tiết"
                                style="padding: 6px 12px;">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                                <h5>Không có lịch hẹn nào</h5>
                                <p class="mb-0">Danh sách trống. Lịch hẹn từ khách hàng sẽ hiển thị tại đây.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
        <div class="pagination-container text-center">
            {{ $bookings->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
        @endif
    </div>
</div>

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

    .table-responsive {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .table-responsive::-webkit-scrollbar {
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

    /* Loading Overlay */
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .loading-overlay.active {
        display: flex;
    }

    .loading-content {
        text-align: center;
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(139, 107, 71, 0.2);
        border-top-color: var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
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

    /* Table Row Hover */
    .table-hover tbody tr {
        transition: background-color 0.2s ease;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(139, 107, 71, 0.05);
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
        font-weight: 500;
        transition: background-color 0.2s, color 0.2s;
    }

    ul.pagination li a:hover,
    ul.pagination li span:hover {
        background: #8B6B47;
        color: #fff;
    }

    /* MOBILE RESPONSIVE */
    @media (max-width: 768px) {

        /* Header */
        .d-flex.justify-content-between {
            flex-direction: column !important;
            gap: 15px;
        }

        h2 {
            font-size: 1.5rem;
        }

        /* Nav Tabs - Scrollable */
        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            border-bottom: 2px solid #dee2e6;
        }

        .nav-tabs::-webkit-scrollbar {
            display: none;
        }

        .nav-tabs .nav-link {
            white-space: nowrap;
            font-size: 11px;
            padding: 10px 14px;
            min-width: fit-content;
        }

        .nav-tabs .badge {
            font-size: 9px;
            padding: 2px 6px;
        }

        /* Table to Card Layout */
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
        }

        .table tbody td {
            display: block;
            width: 100% !important;
            text-align: left !important;
            padding: 10px 0 !important;
            border: none;
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

        /* Empty state */
        .table tbody tr td[colspan] {
            border: none;
            padding: 40px 20px !important;
        }

        /* Pagination */
        .pagination-container {
            padding: 15px 0 30px 0;
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
            padding: 15px !important;
        }
    }

    /* Tablet */
    @media (max-width: 992px) and (min-width: 769px) {
        h2 {
            font-size: 1.75rem;
        }

        .nav-tabs .nav-link {
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
        h2 {
            font-size: 1.25rem;
        }

        .nav-tabs .nav-link {
            font-size: 10px;
            padding: 8px 12px;
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
@endpush