@extends('admin.layouts.app')

@section('title', 'Trang chủ Admin')
@section('page-title', 'Trang chủ Admin')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-home me-3"></i>Trang chủ Admin</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Trang chủ</li>
        </ol>
    </nav>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-value">{{ $stats['total_projects'] }}</div>
                <div class="stat-label">Tổng Dự án</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $stats['active_projects'] }}</div>
                <div class="stat-label">Dự án Đang hoạt động</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value">{{ $stats['pending_bookings'] }}</div>
                <div class="stat-label">Lịch Hẹn Chờ xử lý</div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="stat-value">{{ $stats['pending_quotes'] }}</div>
                <div class="stat-label">Báo giá Chờ xử lý</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <!-- Recent Bookings -->
    <div class="col-lg-6 mb-4">
        <div class="card data-table">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Lịch Hẹn Gần đây</h5>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>

                @forelse($recentBookings as $booking)
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div>
                        <strong>{{ $booking->client_name }}</strong><br>
                        <small class="text-muted">{{ $booking->client_email }}</small><br>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            {{ $booking->booking_time ? \Carbon\Carbon::parse($booking->booking_time)->format('M d, Y H:i') : 'N/A' }}
                        </small>
                    </div>
                    <div>
                        @php
                        $badges = [
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger'
                        ];
                        $bookingStatusMap = [
                        'pending' => 'Đang chờ',
                        'confirmed' => 'Đã xác nhận',
                        'completed' => 'Hoàn thành',
                        'cancelled' => 'Đã hủy'
                        ];
                        @endphp
                        <span class="badge bg-{{ $badges[$booking->status] ?? 'secondary' }}">
                            {{ $bookingStatusMap[$booking->status] ?? ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-center text-muted py-4">Chưa có lịch hẹn nào</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Quotes -->
    <div class="col-lg-6 mb-4">
        <div class="card data-table">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Yêu cầu Báo giá Gần đây</h5>
                    <a href="{{ route('admin.quotes.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>

                @forelse($recentQuotes as $quote)
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div>
                        <strong>{{ $quote->client_name }}</strong><br>
                        <small class="text-muted">{{ $quote->project_type }}</small><br>
                        <small class="text-muted">
                            <i class="fas fa-dollar-sign me-1"></i>
                            Budget: {{ $quote->budget ? number_format($quote->budget) . ' VNĐ' : 'N/A' }}
                        </small>
                    </div>
                    <div>
                        @php
                        $quoteBadges = [
                        'pending' => 'warning',
                        'reviewing' => 'info',
                        'quoted' => 'primary',
                        'accepted' => 'success',
                        'rejected' => 'danger'
                        ];
                        $quoteStatusMap = [
                        'pending' => 'Đang chờ',
                        'reviewing' => 'Đang xem xét',
                        'quoted' => 'Đã báo giá',
                        'accepted' => 'Đã chấp nhận',
                        'rejected' => 'Đã từ chối'
                        ];
                        @endphp
                        <span class="badge bg-{{ $quoteBadges[$quote->status] ?? 'secondary' }}">
                            {{ $quoteStatusMap[$quote->status] ?? ucfirst($quote->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-center text-muted py-4">Chưa có yêu cầu báo giá nào</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Projects -->
<div class="row">
    <div class="col-12">
        <div class="card data-table">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Dự án Gần đây</h5>
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>Thêm Dự án Mới
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dự án</th>
                                <th>Danh mục</th>
                                <th>Vị trí</th>
                                <th>Trạng thái</th>
                                <th>Nổi bật</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProjects as $project)
                            <tr>
                                <td>
                                    <strong>{{ $project->title_vi }}</strong><br>
                                    <small class="text-muted">{{ $project->title_en }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $project->category->name_vi }}</span>
                                </td>
                                <td>{{ $project->location }}</td>
                                <td>
                                    @php
                                    $statusBadges = [
                                    'planning' => 'secondary',
                                    'ongoing' => 'info',
                                    'completed' => 'success'
                                    ];
                                    $projectStatusMap = [
                                    'planning' => 'Đang lên kế hoạch',
                                    'ongoing' => 'Đang thực hiện',
                                    'completed' => 'Hoàn thành'
                                    ];
                                    @endphp
                                    <span class="badge bg-{{ $statusBadges[$project->status] ?? 'secondary' }}">
                                        {{ $projectStatusMap[$project->status] ?? ucfirst($project->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($project->is_featured)
                                    <i class="fas fa-star text-warning"></i>
                                    @else
                                    <i class="far fa-star text-muted"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Chưa có dự án nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection