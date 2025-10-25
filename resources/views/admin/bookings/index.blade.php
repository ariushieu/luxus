@extends('admin.layouts.app')

@section('title', 'Quản lý Lịch hẹn')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-calendar-check text-primary me-2"></i> Quản lý Lịch hẹn</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Lịch hẹn</li>
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
                    href="{{ route('admin.bookings.index') }}">
                    <i class="fas fa-list me-1"></i> Tất cả
                    <span class="badge {{ !request('status') ? 'bg-light text-dark' : 'bg-secondary' }} ms-1">{{ $statusCounts['all'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'pending' ? 'active status-pending' : '' }}"
                    href="{{ route('admin.bookings.index', ['status' => 'pending']) }}">
                    <i class="fas fa-clock me-1"></i> Chờ xác nhận
                    <span class="badge {{ request('status') === 'pending' ? 'bg-light text-dark' : 'bg-warning' }} ms-1">{{ $statusCounts['pending'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'confirmed' ? 'active status-confirmed' : '' }}"
                    href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}">
                    <i class="fas fa-check-circle me-1"></i> Đã xác nhận
                    <span class="badge {{ request('status') === 'confirmed' ? 'bg-light text-dark' : 'bg-info' }} ms-1">{{ $statusCounts['confirmed'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'completed' ? 'active status-completed' : '' }}"
                    href="{{ route('admin.bookings.index', ['status' => 'completed']) }}">
                    <i class="fas fa-check-double me-1"></i> Hoàn thành
                    <span class="badge {{ request('status') === 'completed' ? 'bg-light text-dark' : 'bg-success' }} ms-1">{{ $statusCounts['completed'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === 'cancelled' ? 'active status-cancelled' : '' }}"
                    href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}">
                    <i class="fas fa-times-circle me-1"></i> Đã hủy
                    <span class="badge {{ request('status') === 'cancelled' ? 'bg-light text-dark' : 'bg-danger' }} ms-1">{{ $statusCounts['cancelled'] }}</span>
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
                    <th style="width: 20%"><i class="fas fa-user me-2"></i>Khách hàng</th>
                    <th style="width: 20%"><i class="fas fa-address-book me-2"></i>Liên hệ</th>
                    <th style="width: 15%"><i class="fas fa-calendar me-2"></i>Ngày & Giờ hẹn</th>
                    <th style="width: 12%"><i class="fas fa-info-circle me-2"></i>Trạng thái</th>
                    <th style="width: 15%"><i class="fas fa-clock me-2"></i>Ngày tạo</th>
                    <th style="width: 10%" class="text-center"><i class="fas fa-cog"></i></th>
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
                        <div class="small">
                            <i class="far fa-calendar-plus me-1 text-muted"></i>{{ $booking->created_at->format('d/m/Y') }}
                            <div class="text-muted">
                                <i class="far fa-clock me-1"></i>{{ $booking->created_at->format('H:i') }}
                            </div>
                        </div>
                    </td>
                    <td class="text-center" data-label="Hành động">
                        <a href="{{ route('admin.bookings.show', $booking) }}"
                            class="btn btn-sm btn-primary-custom"
                            title="Xem chi tiết"
                            style="padding: 8px 16px;">
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
    <div class="card-footer bg-white border-top-0">
        <div class="text-muted small mb-2">
            Hiển thị <strong>{{ $bookings->firstItem() ?? 0 }} - {{ $bookings->lastItem() ?? 0 }}</strong>
            trong tổng số <strong>{{ $bookings->total() }}</strong> lịch hẹn
        </div>
        {{ $bookings->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* ẨNHOÀN TOÀN SCROLLBAR */
    * {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    *::-webkit-scrollbar {
        display: none;
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

    .card {
        margin-bottom: 30px;
        max-width: 100%;
        overflow: visible;
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

    /* Desktop styles */
    .table td,
    .table th {
        padding: 12px !important;
        font-size: 14px;
        line-height: 1.5;
        vertical-align: middle;
    }

    .avatar-circle {
        width: 40px !important;
        height: 40px !important;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(139, 107, 71, 0.3);
    }

    .badge {
        padding: 6px 12px;
        font-size: 12px;
    }

    /* Nav Pills - GIỐNG QUOTES */
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

    .nav-pills .nav-link.active.status-confirmed {
        background: linear-gradient(135deg, #17a2b8 0%, #0d8fa8 100%);
        color: white;
    }

    .nav-pills .nav-link.active.status-completed {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }

    .nav-pills .nav-link.active.status-cancelled {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    .nav-pills .nav-link:not(.active):hover {
        background-color: rgba(139, 107, 71, 0.1);
        border-color: #8B6B47;
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

    /* Pagination */
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

    /* Hide data-label on desktop */
    .table td::before {
        display: none;
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

        .avatar-circle {
            width: 45px !important;
            height: 45px !important;
            font-size: 16px !important;
        }

        .badge {
            padding: 8px 14px !important;
            font-size: 13px !important;
        }

        .table tbody td[data-label="Liên hệ"] .small {
            font-size: 14px !important;
        }

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

        .table tbody tr td[colspan] {
            display: table-cell !important;
            border: none;
            padding: 40px 20px !important;
        }

        .table tbody tr td[colspan]::before {
            display: none;
        }

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
            padding: 10px !important;
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
@endpush