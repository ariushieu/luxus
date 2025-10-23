@extends('admin.layouts.app')

@section('title', 'Quản lý Báo giá')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Báo giá</h2>
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
        <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.quotes.index') }}">
            Tất cả <span class="badge bg-secondary">{{ $statusCounts['all'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'pending' ? 'active' : '' }}"
            href="{{ route('admin.quotes.index', ['status' => 'pending']) }}">
            Chờ xử lý <span class="badge bg-warning">{{ $statusCounts['pending'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'reviewing' ? 'active' : '' }}"
            href="{{ route('admin.quotes.index', ['status' => 'reviewing']) }}">
            Đang xem xét <span class="badge bg-info">{{ $statusCounts['reviewing'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'quoted' ? 'active' : '' }}"
            href="{{ route('admin.quotes.index', ['status' => 'quoted']) }}">
            Đã báo giá <span class="badge bg-primary">{{ $statusCounts['quoted'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'accepted' ? 'active' : '' }}"
            href="{{ route('admin.quotes.index', ['status' => 'accepted']) }}">
            Đã chấp nhận <span class="badge bg-success">{{ $statusCounts['accepted'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'rejected' ? 'active' : '' }}"
            href="{{ route('admin.quotes.index', ['status' => 'rejected']) }}">
            Đã từ chối <span class="badge bg-danger">{{ $statusCounts['rejected'] }}</span>
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
                        <th>Loại dự án</th>
                        <th>Ngân sách</th>
                        <th>Số tiền báo giá</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th style="width: 100px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotes as $quote)
                    <tr>
                        <td>
                            <strong>{{ $quote->name }}</strong>
                        </td>
                        <td>
                            <div>
                                <i class="fas fa-envelope text-muted"></i> {{ $quote->email }}
                                <br>
                                <i class="fas fa-phone text-muted"></i> {{ $quote->phone }}
                            </div>
                        </td>
                        <td>{{ $quote->project_type ?? '-' }}</td>
                        <td>{{ $quote->budget ?? '-' }}</td>
                        <td>
                            @if($quote->quoted_amount)
                            <strong class="text-primary">{{ number_format($quote->quoted_amount, 0, ',', '.') }} VNĐ</strong>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($quote->status === 'pending')
                            <span class="badge bg-warning">Chờ xử lý</span>
                            @elseif($quote->status === 'reviewing')
                            <span class="badge bg-info">Đang xem xét</span>
                            @elseif($quote->status === 'quoted')
                            <span class="badge bg-primary">Đã báo giá</span>
                            @elseif($quote->status === 'accepted')
                            <span class="badge bg-success">Đã chấp nhận</span>
                            @elseif($quote->status === 'rejected')
                            <span class="badge bg-danger">Đã từ chối</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $quote->created_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.quotes.show', $quote) }}"
                                class="btn btn-sm btn-primary"
                                title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Không có yêu cầu báo giá nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $quotes->links() }}
        </div>
    </div>
</div>
@endsection