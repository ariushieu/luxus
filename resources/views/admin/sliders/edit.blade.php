@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Slider')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Chỉnh sửa Slider</h2>
    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
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

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none;">
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-white fw-bold">Đang tải ảnh lên Cloudinary...</p>
    </div>
</div>

<form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data" id="sliderForm">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Left Column -->
        <div class="col-md-8">
            <!-- Current Image & Upload New -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Hình ảnh Slider</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Ảnh hiện tại:</label>
                        <img src="{{ $slider->cloudinary_url }}"
                            alt="{{ $slider->title_vi }}"
                            class="img-fluid rounded d-block mb-3"
                            style="max-height: 300px; width: 100%; object-fit: cover;">
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Chọn ảnh mới (Tùy chọn)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                            id="image" name="image" accept="image/*"
                            onchange="previewImage(event)">
                        <small class="text-muted">Để trống nếu không muốn thay đổi ảnh. Khuyến nghị: 1920x1080px</small>
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview"></div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cài đặt</h5>
                </div>
                <div class="card-body">
                    <!-- Display Order -->
                    <div class="mb-3">
                        <label for="display_order" class="form-label">Thứ tự hiển thị</label>
                        <input type="number" class="form-control"
                            id="display_order" name="display_order"
                            value="{{ old('display_order', $slider->display_order) }}" min="0">
                        <small class="text-muted">Số nhỏ hơn sẽ hiển thị trước</small>
                    </div>

                    <!-- Active Status -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active"
                                name="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Hiển thị trên trang chủ
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                        <i class="fas fa-save"></i> Cập nhật Slider
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loading-spinner {
        text-align: center;
    }
</style>
@endpush

@push('scripts')
<script>
    let isSubmitting = false;
    document.getElementById('sliderForm').addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }

        const fileInput = document.getElementById('image');
        if (fileInput.files.length > 0) {
            isSubmitting = true;
            document.getElementById('loadingOverlay').style.display = 'flex';
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang tải lên...';
        }
    });

    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                <label class="form-label">Xem trước ảnh mới:</label>
                <img src="${e.target.result}" class="img-fluid rounded" 
                     style="max-height: 300px; width: 100%; object-fit: cover;">
            `;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    }
</script>
@endpush
@endsection