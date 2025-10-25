@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Danh mục')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Chỉnh sửa Danh mục</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
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
        <p class="mt-3 text-white fw-bold">Đang cập nhật danh mục...</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" id="categoryForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="is_active" value="0">

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin Danh mục</h5>
                </div>
                <div class="card-body">
                    <!-- Vietnamese Name -->
                    <div class="mb-3">
                        <label for="name_vi" class="form-label">Tên Danh mục (Tiếng Việt) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name_vi') is-invalid @enderror"
                            id="name_vi" name="name_vi" value="{{ old('name_vi', $category->name_vi) }}" required>
                        @error('name_vi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- English Name -->
                    <div class="mb-3">
                        <label for="name_en" class="form-label">Tên Danh mục (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                            id="name_en" name="name_en" value="{{ old('name_en', $category->name_en) }}" required>
                        @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                            id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required>
                        <small class="text-muted">URL-friendly identifier (ví dụ: housing, commercial, office)</small>
                        @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Vietnamese Description -->
                    <div class="mb-3">
                        <label for="description_vi" class="form-label">Mô tả (Tiếng Việt)</label>
                        <textarea class="form-control @error('description_vi') is-invalid @enderror"
                            id="description_vi" name="description_vi" rows="3">{{ old('description_vi', $category->description_vi) }}</textarea>
                        @error('description_vi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- English Description -->
                    <div class="mb-3">
                        <label for="description_en" class="form-label">Mô tả (English)</label>
                        <textarea class="form-control @error('description_en') is-invalid @enderror"
                            id="description_en" name="description_en" rows="3">{{ old('description_en', $category->description_en) }}</textarea>
                        @error('description_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active"
                                name="is_active" value="1"
                                {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Hiển thị trên website
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i> Cập nhật Danh mục
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

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
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        // Ngăn chặn submit nhiều lần
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }

        isSubmitting = true;
        const submitBtn = document.getElementById('submitBtn');

        // Disable button và show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang cập nhật...';

        // Show loading overlay
        document.getElementById('loadingOverlay').style.display = 'flex';
    });
</script>
@endpush

@endsection