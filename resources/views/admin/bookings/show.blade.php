@extends('admin.layouts.app')

@section('title', 'Chi tiết Lịch hẹn')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Chi tiết Lịch hẹn #{{ $booking->id }}</h2>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

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
    <div class="col-lg-8">
        <!-- Booking Information -->
        <div class="card mb-4" style="border: none; box-shadow: 0 8px 24px rgba(139, 107, 71, 0.12); border-radius: 16px;">
            <div class="card-header" style="background: linear-gradient(135deg, #F5F1E8 0%, #ffffff 100%); border-bottom: 2px solid #D4AF37; border-radius: 16px 16px 0 0;">
                <h5 class="mb-0" style="color: #3E2C1F; font-weight: 700;">
                    <i class="fas fa-user-circle me-2 text-primary"></i>Thông tin Khách hàng
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-user me-2"></i>Họ tên
                            </label>
                            <div class="fw-bold fs-5">{{ $booking->client_name ?? "N/A" }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-phone me-2"></i>Điện thoại
                            </label>
                            <div class="fw-bold fs-5">
                                <a href="tel:{{ $booking->client_phone }}" class="text-decoration-none text-success">
                                    {{ $booking->client_phone ?? "N/A" }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <div class="fw-bold fs-5">
                                <a href="mailto:{{ $booking->client_email }}" class="text-decoration-none text-primary">
                                    {{ $booking->client_email ?? "N/A" }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-calendar-alt me-2"></i>Ngày hẹn
                            </label>
                            <div class="fw-bold text-primary">
                                {{ \Carbon\Carbon::parse($booking->booking_time)->format("d/m/Y") }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-clock me-2"></i>Giờ hẹn
                            </label>
                            <div class="fw-bold text-primary">
                                {{ \Carbon\Carbon::parse($booking->booking_time)->format("H:i") }}
                            </div>
                        </div>
                    </div>

                    @if($booking->message)
                    <div class="col-12">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-comment-dots me-2"></i>Lời nhắn từ khách hàng
                            </label>
                            <div class="p-3 bg-light rounded" style="white-space: pre-wrap; line-height: 1.6;">{{ $booking->message }}</div>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-calendar-plus me-2"></i>Ngày tạo yêu cầu
                            </label>
                            <div class="fw-bold">{{ $booking->created_at->format("d/m/Y H:i:s") }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-sync-alt me-2"></i>Cập nhật lần cuối
                            </label>
                            <div class="fw-bold">{{ $booking->updated_at->format("d/m/Y H:i:s") }}</div>
                        </div>
                    </div>
                </div>

                @if($booking->admin_notes)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-sticky-note me-2"></i>Ghi chú nội bộ
                            </label>
                            <div class="p-3 bg-warning bg-opacity-10 rounded border border-warning" style="white-space: pre-wrap;">{{ $booking->admin_notes }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Update Status -->
        <div class="card sticky-top" style="border: none; box-shadow: 0 8px 24px rgba(139, 107, 71, 0.12); border-radius: 16px; top: 100px;">
            <div class="card-header" style="background: linear-gradient(135deg, #8B6B47 0%, #D4AF37 100%); color: white; border-radius: 16px 16px 0 0;">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-edit me-2"></i>Cập nhật Trạng thái
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route("admin.bookings.status", $booking) }}" method="POST" id="bookingForm">
                    @csrf
                    @method("PATCH")

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted mb-2">
                            <i class="fas fa-info-circle me-1"></i>Trạng thái hiện tại
                        </label>
                        <div>
                            @if($booking->status === "pending")
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                <i class="fas fa-clock me-1"></i>Chờ xác nhận
                            </span>
                            @elseif($booking->status === "confirmed")
                            <span class="badge bg-info fs-6 px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>Đã xác nhận
                            </span>
                            @elseif($booking->status === "completed")
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="fas fa-check-double me-1"></i>Hoàn thành
                            </span>
                            @elseif($booking->status === "cancelled")
                            <span class="badge bg-danger fs-6 px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i>Đã hủy
                            </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">
                            <i class="fas fa-exchange-alt me-1"></i>Chuyển sang trạng thái
                        </label>
                        <select class="form-select @error("status") is-invalid @enderror"
                            id="status" name="status" required
                            style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 10px;">
                            <option value="pending" {{ $booking->status === "pending" ? "selected" : "" }}>
                                 Chờ xác nhận
                            </option>
                            <option value="confirmed" {{ $booking->status === "confirmed" ? "selected" : "" }}>
                                 Đã xác nhận
                            </option>
                            <option value="completed" {{ $booking->status === "completed" ? "selected" : "" }}>
                                 Hoàn thành
                            </option>
                            <option value="cancelled" {{ $booking->status === "cancelled" ? "selected" : "" }}>
                                 Đã hủy
                            </option>
                        </select>
                        @error("status")
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="admin_notes" class="form-label fw-bold">
                            <i class="fas fa-sticky-note me-1"></i>Ghi chú nội bộ
                        </label>
                        <textarea class="form-control @error("admin_notes") is-invalid @enderror"
                            id="admin_notes" name="admin_notes" rows="5"
                            placeholder="Thêm ghi chú về lịch hẹn này..."
                            style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 12px;">{{ old("admin_notes", $booking->admin_notes) }}</textarea>
                        @error("admin_notes")
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100" id="updateBookingBtn">
                        <i class="fas fa-save me-2"></i>Cập nhật Lịch hẹn
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-3" style="border: none; box-shadow: 0 4px 15px rgba(139, 107, 71, 0.08); border-radius: 12px;">
            <div class="card-body p-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-bolt me-2 text-warning"></i>Thao tác nhanh</h6>
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $booking->client_email }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-envelope me-2"></i>Gửi Email
                    </a>
                    <a href="tel:{{ $booking->client_phone }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-phone me-2"></i>Gọi điện
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push("scripts")
<script>
    document.getElementById("bookingForm").addEventListener("submit", function(e) {
        const btn = document.getElementById("updateBookingBtn");
        const originalHtml = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = "<span class=\"spinner-border spinner-border-sm me-2\" role=\"status\"></span>Đang xử lý...";
        
        setTimeout(function() {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }, 5000);
    });
</script>
@endpush
@endsection
