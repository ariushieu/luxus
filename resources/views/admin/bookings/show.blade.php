@extends('admin.layouts.app')

@section('title', 'Chi tiết Lịch hẹn')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Chi tiết Lịch hẹn #{{ $booking->id }}</h2>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
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

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Có lỗi xảy ra:</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <div class="col-md-8">
        <!-- Booking Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Thông tin Khách hàng</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Họ tên:</strong></div>
                    <div class="col-md-9">{{ $booking->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Email:</strong></div>
                    <div class="col-md-9">
                        <a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Điện thoại:</strong></div>
                    <div class="col-md-9">
                        <a href="tel:{{ $booking->phone }}">{{ $booking->phone }}</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Ngày hẹn:</strong></div>
                    <div class="col-md-9">
                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Giờ hẹn:</strong></div>
                    <div class="col-md-9">
                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                    </div>
                </div>
                @if($booking->message)
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Lời nhắn:</strong></div>
                    <div class="col-md-9">
                        <p class="mb-0">{{ $booking->message }}</p>
                    </div>
                </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Ngày tạo:</strong></div>
                    <div class="col-md-9">
                        {{ $booking->created_at->format('d/m/Y H:i:s') }}
                    </div>
                </div>
                @if($booking->admin_notes)
                <div class="row">
                    <div class="col-md-3"><strong>Ghi chú Admin:</strong></div>
                    <div class="col-md-9">
                        <p class="mb-0 text-muted">{{ $booking->admin_notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Update Status -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cập nhật Trạng thái</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Current Status -->
                    <div class="mb-3">
                        <label class="form-label">Trạng thái hiện tại:</label>
                        <div>
                            @if($booking->status === 'pending')
                            <span class="badge bg-warning">Chờ xác nhận</span>
                            @elseif($booking->status === 'confirmed')
                            <span class="badge bg-info">Đã xác nhận</span>
                            @elseif($booking->status === 'completed')
                            <span class="badge bg-success">Hoàn thành</span>
                            @elseif($booking->status === 'cancelled')
                            <span class="badge bg-danger">Đã hủy</span>
                            @endif
                        </div>
                    </div>

                    <!-- New Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái mới:</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status" required>
                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Admin Notes -->
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Ghi chú:</label>
                        <textarea class="form-control @error('admin_notes') is-invalid @enderror"
                            id="admin_notes" name="admin_notes" rows="4"
                            placeholder="Ghi chú nội bộ...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                        @error('admin_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection