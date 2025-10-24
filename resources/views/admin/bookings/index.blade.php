@extends('admin.layouts.app')

@section('title', 'Quản lý Lịch hẹn')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Lịch hẹn</h2>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

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
                        <td>
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
                        <td>
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
                        <td>
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
                        <td>
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
                        <td>
                            <small class="text-muted">
                                <i class="far fa-calendar-plus me-1"></i>
                                {{ $booking->created_at->format('d/m/Y H:i') }}
                            </small>
                        </td>
                        <td class="text-center">
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

        <div class="mt-3">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection