@extends('admin.layouts.app')

@section('title', 'Thêm Danh mục')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Thêm Danh mục</h2>
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

<div class="row">
    <div class="col-md-8">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin Danh mục</h5>
                </div>
                <div class="card-body">
                    <!-- Vietnamese Name -->
                    <div class="mb-3">
                        <label for="name_vi" class="form-label">Tên Danh mục (Tiếng Việt) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name_vi') is-invalid @enderror"
                            id="name_vi" name="name_vi" value="{{ old('name_vi') }}" required>
                        @error('name_vi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- English Name -->
                    <div class="mb-3">
                        <label for="name_en" class="form-label">Tên Danh mục (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                            id="name_en" name="name_en" value="{{ old('name_en') }}" required>
                        @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                            id="slug" name="slug" value="{{ old('slug') }}" required>
                        <small class="text-muted">URL-friendly identifier (ví dụ: housing, commercial, office)</small>
                        @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Vietnamese Description -->
                    <div class="mb-3">
                        <label for="description_vi" class="form-label">Mô tả (Tiếng Việt)</label>
                        <textarea class="form-control @error('description_vi') is-invalid @enderror"
                            id="description_vi" name="description_vi" rows="3">{{ old('description_vi') }}</textarea>
                        @error('description_vi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- English Description -->
                    <div class="mb-3">
                        <label for="description_en" class="form-label">Mô tả (English)</label>
                        <textarea class="form-control @error('description_en') is-invalid @enderror"
                            id="description_en" name="description_en" rows="3">{{ old('description_en') }}</textarea>
                        @error('description_en')
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu Danh mục
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from Vietnamese name
    document.getElementById('name_vi').addEventListener('input', function(e) {
        const slug = e.target.value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/\s+/g, '-');

        document.getElementById('slug').value = slug;
    });
</script>
@endpush
@endsection