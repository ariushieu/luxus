@extends('admin.layouts.app')

@section('title', 'Chi tiết Báo giá')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Chi tiết Báo giá #{{ $quote->id }}</h2>
    <a href="{{ route('admin.quotes.index') }}" class="btn btn-secondary">
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
        <!-- Quote Information -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Thông tin Khách hàng</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Họ tên:</strong></div>
                    <div class="col-md-9">{{ $quote->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Email:</strong></div>
                    <div class="col-md-9">
                        <a href="mailto:{{ $quote->email }}">{{ $quote->email }}</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Điện thoại:</strong></div>
                    <div class="col-md-9">
                        <a href="tel:{{ $quote->phone }}">{{ $quote->phone }}</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Loại dự án:</strong></div>
                    <div class="col-md-9">{{ $quote->project_type ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Ngân sách dự kiến:</strong></div>
                    <div class="col-md-9">{{ $quote->budget ?? '-' }}</div>
                </div>
                @if($quote->message)
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Mô tả yêu cầu:</strong></div>
                    <div class="col-md-9">
                        <p class="mb-0">{{ $quote->message }}</p>
                    </div>
                </div>
                @endif
                @if($quote->quoted_amount)
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Số tiền báo giá:</strong></div>
                    <div class="col-md-9">
                        <h4 class="mb-0 text-primary">{{ number_format($quote->quoted_amount, 0, ',', '.') }} VNĐ</h4>
                    </div>
                </div>
                @endif
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Ngày tạo:</strong></div>
                    <div class="col-md-9">
                        {{ $quote->created_at->format('d/m/Y H:i:s') }}
                    </div>
                </div>
                @if($quote->admin_notes)
                <div class="row">
                    <div class="col-md-3"><strong>Ghi chú Admin:</strong></div>
                    <div class="col-md-9">
                        <p class="mb-0 text-muted">{{ $quote->admin_notes }}</p>
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
                <h5 class="mb-0">Cập nhật Báo giá</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.quotes.status', $quote) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Current Status -->
                    <div class="mb-3">
                        <label class="form-label">Trạng thái hiện tại:</label>
                        <div>
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
                        </div>
                    </div>

                    <!-- New Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái mới:</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status" required>
                            <option value="pending" {{ $quote->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="reviewing" {{ $quote->status === 'reviewing' ? 'selected' : '' }}>Đang xem xét</option>
                            <option value="quoted" {{ $quote->status === 'quoted' ? 'selected' : '' }}>Đã báo giá</option>
                            <option value="accepted" {{ $quote->status === 'accepted' ? 'selected' : '' }}>Đã chấp nhận</option>
                            <option value="rejected" {{ $quote->status === 'rejected' ? 'selected' : '' }}>Đã từ chối</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Quoted Amount (show when status is 'quoted') -->
                    <div class="mb-3" id="quotedAmountDiv" style="display: none;">
                        <label for="quoted_amount" class="form-label">Số tiền báo giá (VNĐ):</label>
                        <input type="number" class="form-control @error('quoted_amount') is-invalid @enderror"
                            id="quoted_amount" name="quoted_amount"
                            value="{{ old('quoted_amount', $quote->quoted_amount) }}"
                            step="1000" min="0"
                            placeholder="Ví dụ: 50000000">
                        @error('quoted_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Admin Notes -->
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Ghi chú:</label>
                        <textarea class="form-control @error('admin_notes') is-invalid @enderror"
                            id="admin_notes" name="admin_notes" rows="4"
                            placeholder="Ghi chú nội bộ...">{{ old('admin_notes', $quote->admin_notes) }}</textarea>
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

@push('scripts')
<script>
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
    });
</script>
@endpush
@endsection