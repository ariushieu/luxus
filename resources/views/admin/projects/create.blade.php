@extends('admin.layouts.app')

@section('title', 'Thêm Dự án Mới')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Thêm Dự án Mới</h2>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
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

<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" id="projectForm">
    @csrf

    <div class="row">
        <!-- Left Column -->
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin Dự án</h5>
                </div>
                <div class="card-body">
                    <!-- Vietnamese Title -->
                    <div class="mb-3">
                        <label for="title_vi" class="form-label">Tiêu đề Dự án (Tiếng Việt) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title_vi') is-invalid @enderror"
                            id="title_vi" name="title_vi" value="{{ old('title_vi') }}" required>
                        @error('title_vi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- English Title -->
                    <div class="mb-3">
                        <label for="title_en" class="form-label">Tiêu đề Dự án (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title_en') is-invalid @enderror"
                            id="title_en" name="title_en" value="{{ old('title_en') }}" required>
                        @error('title_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Vietnamese Description -->
                    <div class="mb-3">
                        <label for="description_vi" class="form-label">Mô tả (Tiếng Việt)</label>
                        <textarea class="form-control @error('description_vi') is-invalid @enderror"
                            id="description_vi" name="description_vi" rows="4">{{ old('description_vi') }}</textarea>
                        @error('description_vi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- English Description -->
                    <div class="mb-3">
                        <label for="description_en" class="form-label">Mô tả (English)</label>
                        <textarea class="form-control @error('description_en') is-invalid @enderror"
                            id="description_en" name="description_en" rows="4">{{ old('description_en') }}</textarea>
                        @error('description_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Additional Info Row -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label">Tên Khách hàng</label>
                            <input type="text" class="form-control" id="client_name"
                                name="client_name" value="{{ old('client_name') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">Địa điểm</label>
                            <input type="text" class="form-control" id="location"
                                name="location" value="{{ old('location') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">Diện tích (m²)</label>
                            <input type="number" class="form-control" id="area"
                                name="area" value="{{ old('area') }}" step="0.01">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="completed_at" class="form-label">Ngày Hoàn thành</label>
                            <input type="date" class="form-control" id="completed_at"
                                name="completed_at" value="{{ old('completed_at') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images Upload -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Hình ảnh Dự án</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="images" class="form-label">Chọn hình ảnh (Ảnh đầu tiên sẽ là ảnh chính)</label>
                        <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                            id="images" name="images[]" accept="image/*" multiple
                            onchange="previewImages(event)">
                        <small class="text-muted">Hỗ trợ: JPG, PNG, WEBP. Tối đa 5MB/ảnh</small>
                        @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="row g-2"></div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Cài đặt</h5>
                </div>
                <div class="card-body">
                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror"
                            id="category_id" name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name_vi }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active"
                                name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Hiển thị trên website
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                        <i class="fas fa-save"></i> Lưu Dự án
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
    // Prevent double submission
    let isSubmitting = false;
    document.getElementById('projectForm').addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }

        // Check if images selected
        const filesInput = document.getElementById('images');
        if (filesInput.files.length > 0) {
            isSubmitting = true;
            document.getElementById('loadingOverlay').style.display = 'flex';
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang tải lên...';
        }
    });

    function previewImages(event) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';

        const files = event.target.files;

        if (files.length === 0) return;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3';
                col.innerHTML = `
                <div class="position-relative">
                    <img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                    ${i === 0 ? '<span class="badge bg-primary position-absolute top-0 start-0 m-1">Ảnh chính</span>' : ''}
                </div>
            `;
                preview.appendChild(col);
            };

            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection