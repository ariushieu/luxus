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
                    <td class="fw-bold text-muted">{{ $quote->id }}</td>
                    <td>
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
                    <td>
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
                    <td>
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
                    <td>
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
                    <td>
                        @if($quote->quoted_amount)
                        <strong class="text-primary" style="font-size: 1.05rem;">
                            {{ number_format($quote->quoted_amount, 0, ',', '.') }}
                        </strong>
                        <small class="text-muted d-block">VNĐ</small>
                        @else
                        <span class="text-muted">Chưa báo giá</span>
                        @endif
                    </td>
                    <td>
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
                    <td>
                        <div class="small">
                            <i class="fas fa-calendar-alt text-muted me-1"></i>{{ $quote->created_at->format('d/m/Y') }}
                            <div class="text-muted">
                                <i class="far fa-clock me-1"></i>{{ $quote->created_at->format('H:i') }}
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
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
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Hiển thị {{ $quotes->firstItem() ?? 0 }} - {{ $quotes->lastItem() ?? 0 }}
                trong tổng số {{ $quotes->total() }} yêu cầu
            </div>
            <div>
                {{ $quotes->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .nav-pills .nav-link {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
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
        transform: translateY(-2px);
    }

    .avatar-circle {
        box-shadow: 0 2px 8px rgba(139, 107, 71, 0.3);
    }

    .project-type-badge {
        font-size: 0.85rem;
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