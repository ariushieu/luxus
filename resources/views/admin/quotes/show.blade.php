@extends('admin.layouts.app')

@section('title', 'Chi tiết Báo giá')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-file-invoice-dollar text-primary me-2"></i> Chi tiết Báo giá #{{ $quote->id }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.quotes.index') }}">Báo giá</a></li>
                    <li class="breadcrumb-item active">Chi tiết #{{ $quote->id }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.quotes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>
</div>

{{-- Alerts are now handled in layout.app.blade.php --}}
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
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
        <!-- Quote Information -->
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
                            <div class="fw-bold fs-5">{{ $quote->client_name ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-phone me-2"></i>Điện thoại
                            </label>
                            <div class="fw-bold fs-5">
                                <a href="tel:{{ $quote->client_phone }}" class="text-decoration-none text-success">
                                    {{ $quote->client_phone ?? 'N/A' }}
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
                                <a href="mailto:{{ $quote->client_email }}" class="text-decoration-none text-primary">
                                    {{ $quote->client_email ?? 'N/A' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Details -->
        <div class="card mb-4" style="border: none; box-shadow: 0 8px 24px rgba(139, 107, 71, 0.12); border-radius: 16px;">
            <div class="card-header" style="background: linear-gradient(135deg, #F5F1E8 0%, #ffffff 100%); border-bottom: 2px solid #D4AF37; border-radius: 16px 16px 0 0;">
                <h5 class="mb-0" style="color: #3E2C1F; font-weight: 700;">
                    <i class="fas fa-building me-2 text-primary"></i>Chi tiết Dự án
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    @if($quote->reference_project)
                    <div class="col-12">
                        <div class="alert alert-info mb-0" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border: none;">
                            <i class="fas fa-project-diagram me-2"></i>
                            <strong>Dự án quan tâm:</strong> {{ $quote->reference_project }}
                        </div>
                    </div>
                    @endif

                    <div class="col-md-4">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-home me-2"></i>Loại dự án
                            </label>
                            @php
                            $projectTypes = [
                            'housing' => 'Nhà ở',
                            'apartment' => 'Căn hộ',
                            'office' => 'Văn phòng',
                            'commercial' => 'Thương mại',
                            ];
                            @endphp
                            <div class="fw-bold">{{ $projectTypes[$quote->project_type] ?? $quote->project_type ?? 'N/A' }}</div>
                        </div>
                    </div>

                    @if($quote->area)
                    <div class="col-md-4">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-ruler-combined me-2"></i>Diện tích
                            </label>
                            <div class="fw-bold fs-5 text-primary">{{ number_format($quote->area, 0) }} m²</div>
                        </div>
                    </div>
                    @endif

                    @if($quote->budget)
                    <div class="col-md-4">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-money-bill-wave me-2"></i>Ngân sách dự kiến
                            </label>
                            <div class="fw-bold fs-5 text-success">{{ number_format($quote->budget, 0, ',', '.') }} VNĐ</div>
                        </div>
                    </div>
                    @endif

                    @if($quote->request_details)
                    <div class="col-12">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-file-alt me-2"></i>Yêu cầu chi tiết
                            </label>
                            <div class="p-3 bg-light rounded" style="white-space: pre-wrap; line-height: 1.6;">{{ $quote->request_details }}</div>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-calendar-plus me-2"></i>Ngày gửi yêu cầu
                            </label>
                            <div class="fw-bold">{{ $quote->created_at->format('d/m/Y H:i:s') }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-clock me-2"></i>Cập nhật lần cuối
                            </label>
                            <div class="fw-bold">{{ $quote->updated_at->format('d/m/Y H:i:s') }}</div>
                        </div>
                    </div>
                </div>

                @if($quote->quoted_amount)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert mb-0" style="background: linear-gradient(135deg, #8B6B47 0%, #D4AF37 100%); color: white; border: none;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-dollar-sign me-2"></i>
                                    <strong>Số tiền đã báo giá:</strong>
                                </div>
                                <h3 class="mb-0 fw-bold">{{ number_format($quote->quoted_amount, 0, ',', '.') }} VNĐ</h3>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($quote->admin_notes)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="info-item">
                            <label class="text-muted small mb-1">
                                <i class="fas fa-sticky-note me-2"></i>Ghi chú nội bộ
                            </label>
                            <div class="p-3 bg-warning bg-opacity-10 rounded border border-warning" style="white-space: pre-wrap;">{{ $quote->admin_notes }}</div>
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
                    <i class="fas fa-edit me-2"></i>Cập nhật Báo giá
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.quotes.status', $quote) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Current Status -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted mb-2">
                            <i class="fas fa-info-circle me-1"></i>Trạng thái hiện tại
                        </label>
                        <div>
                            @if($quote->status === 'pending')
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                <i class="fas fa-clock me-1"></i>Chờ xử lý
                            </span>
                            @elseif($quote->status === 'reviewing')
                            <span class="badge bg-info fs-6 px-3 py-2">
                                <i class="fas fa-eye me-1"></i>Đang xem xét
                            </span>
                            @elseif($quote->status === 'quoted')
                            <span class="badge bg-primary fs-6 px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>Đã báo giá
                            </span>
                            @elseif($quote->status === 'accepted')
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="fas fa-handshake me-1"></i>Đã chấp nhận
                            </span>
                            @elseif($quote->status === 'rejected')
                            <span class="badge bg-danger fs-6 px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i>Đã từ chối
                            </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- New Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">
                            <i class="fas fa-exchange-alt me-1"></i>Chuyển sang trạng thái
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status" required
                            style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 10px;">
                            <option value="pending" {{ $quote->status === 'pending' ? 'selected' : '' }}>
                                🕐 Chờ xử lý
                            </option>
                            <option value="reviewing" {{ $quote->status === 'reviewing' ? 'selected' : '' }}>
                                👁️ Đang xem xét
                            </option>
                            <option value="quoted" {{ $quote->status === 'quoted' ? 'selected' : '' }}>
                                ✅ Đã báo giá
                            </option>
                            <option value="accepted" {{ $quote->status === 'accepted' ? 'selected' : '' }}>
                                🤝 Đã chấp nhận
                            </option>
                            <option value="rejected" {{ $quote->status === 'rejected' ? 'selected' : '' }}>
                                ❌ Đã từ chối
                            </option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Quoted Amount (show when status is 'quoted') -->
                    <div class="mb-3" id="quotedAmountDiv" style="display: none;">
                        <label for="quoted_amount" class="form-label fw-bold">
                            <i class="fas fa-dollar-sign me-1"></i>Số tiền báo giá <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('quoted_amount') is-invalid @enderror"
                                id="quoted_amount" name="quoted_amount"
                                value="{{ old('quoted_amount', $quote->quoted_amount) }}"
                                step="1000" min="0"
                                placeholder="50000000"
                                style="border: 2px solid #e0e0e0; padding: 10px;">
                            <span class="input-group-text" style="background: linear-gradient(135deg, #8B6B47 0%, #D4AF37 100%); color: white; border: none; font-weight: bold;">VNĐ</span>
                        </div>
                        <small class="text-muted">Ví dụ: 50000000 = 50 triệu</small>
                        @error('quoted_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Admin Notes -->
                    <div class="mb-4">
                        <label for="admin_notes" class="form-label fw-bold">
                            <i class="fas fa-sticky-note me-1"></i>Ghi chú nội bộ
                        </label>
                        <textarea class="form-control @error('admin_notes') is-invalid @enderror"
                            id="admin_notes" name="admin_notes" rows="4"
                            placeholder="Ghi chú nội bộ..."
                            style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 12px;">{{ old('admin_notes', $quote->admin_notes) }}</textarea>
                        @error('admin_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100" id="updateQuoteBtn">
                        <i class="fas fa-save me-2"></i>Cập nhật Báo giá
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-3" style="border: none; box-shadow: 0 4px 15px rgba(139, 107, 71, 0.08); border-radius: 12px;">
            <div class="card-body p-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-bolt me-2 text-warning"></i>Thao tác nhanh</h6>
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $quote->client_email }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-envelope me-2"></i>Gửi Email
                    </a>
                    <a href="tel:{{ $quote->client_phone }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-phone me-2"></i>Gọi điện
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Status change handler
    document.getElementById('status').addEventListener('change', function(e) {
        const quotedAmountDiv = document.getElementById('quotedAmountDiv');
        const quotedAmountInput = document.getElementById('quoted_amount');

        if (e.target.value === 'quoted') {
            quotedAmountDiv.style.display = 'block';
            quotedAmountInput.required = true;
        } else {
            quotedAmountDiv.style.display = 'none';
            quotedAmountInput.required = false;
        }
    });

    // Check on page load
    document.addEventListener('DOMContentLoaded', function() {
        const status = document.getElementById('status').value;
        if (status === 'quoted') {
            document.getElementById('quotedAmountDiv').style.display = 'block';
            document.getElementById('quoted_amount').required = true;
        }

        // Form submission with loading state
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.getElementById('updateQuoteBtn');
            const originalHtml = btn.innerHTML;

            // Disable button and show loading
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Đang xử lý...';

            // Re-enable after 5s in case of error
            setTimeout(function() {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }, 5000);
        });
    });
</script>
@endpush
@endsection