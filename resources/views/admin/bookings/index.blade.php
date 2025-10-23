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
                            <strong>{{ $booking->name }}</strong>
                        </td>
                        <td>
                            <div>
                                <i class="fas fa-envelope text-muted"></i> {{ $booking->email }}
                                <br>
                                <i class="fas fa-phone text-muted"></i> {{ $booking->phone }}
                            </div>
                        </td>
                        <td>
                            <div>
                                <i class="fas fa-calendar text-muted"></i> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                                <br>
                                <i class="fas fa-clock text-muted"></i> {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                            </div>
                        </td>
                        <td>
                            @if($booking->status === 'pending')
                            <span class="badge bg-warning">Chờ xác nhận</span>
                            @elseif($booking->status === 'confirmed')
                            <span class="badge bg-info">Đã xác nhận</span>
                            @elseif($booking->status === 'completed')
                            <span class="badge bg-success">Hoàn thành</span>
                            @elseif($booking->status === 'cancelled')
                            <span class="badge bg-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $booking->created_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.bookings.show', $booking) }}"
                                class="btn btn-sm btn-primary"
                                title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Không có lịch hẹn nào.
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