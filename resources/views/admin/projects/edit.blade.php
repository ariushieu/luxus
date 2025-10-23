@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Dự án')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Chỉnh sửa Dự án</h2>
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
        <p class="mt-3 text-white fw-bold" id="loadingText">Đang xử lý...</p>
    </div>
</div>

<form action="{{ route('admin.projects.update', $project) }}" method="POST" id="editForm">
    @csrf
    @method('PUT')

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
                            id="title_vi" name="title_vi" value="{{ old('title_vi', $project->title_vi) }}" required>
                        @error('title_vi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- English Title -->
                    <div class="mb-3">
                        <label for="title_en" class="form-label">Tiêu đề Dự án (English) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title_en') is-invalid @enderror"
                            id="title_en" name="title_en" value="{{ old('title_en', $project->title_en) }}" required>
                        @error('title_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Vietnamese Description -->
                    <div class="mb-3">
                        <label for="description_vi" class="form-label">Mô tả (Tiếng Việt)</label>
                        <textarea class="form-control @error('description_vi') is-invalid @enderror"
                            id="description_vi" name="description_vi" rows="4">{{ old('description_vi', $project->description_vi) }}</textarea>
                        @error('description_vi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- English Description -->
                    <div class="mb-3">
                        <label for="description_en" class="form-label">Mô tả (English)</label>
                        <textarea class="form-control @error('description_en') is-invalid @enderror"
                            id="description_en" name="description_en" rows="4">{{ old('description_en', $project->description_en) }}</textarea>
                        @error('description_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Additional Info Row -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label">Tên Khách hàng</label>
                            <input type="text" class="form-control" id="client_name"
                                name="client_name" value="{{ old('client_name', $project->client_name) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label">Địa điểm</label>
                            <input type="text" class="form-control" id="location"
                                name="location" value="{{ old('location', $project->location) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">Diện tích (m²)</label>
                            <input type="number" class="form-control" id="area"
                                name="area" value="{{ old('area', $project->area) }}" step="0.01">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="completed_at" class="form-label">Ngày Hoàn thành</label>
                            <input type="date" class="form-control" id="completed_at"
                                name="completed_at" value="{{ old('completed_at', $project->completed_at?->format('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Existing Images -->
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hình ảnh Dự án ({{ $project->images->count() }})</h5>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fas fa-plus"></i> Thêm ảnh
                    </button>
                </div>
                <div class="card-body">
                    @if($project->images->count() > 0)
                    <div class="row g-2">
                        @foreach($project->images as $image)
                        <div class="col-md-3">
                            <div class="card">
                                <img src="{{ $image->cloudinary_url }}"
                                    class="card-img-top"
                                    style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    @if($image->is_primary)
                                    <span class="badge bg-primary w-100 mb-1">Ảnh chính</span>
                                    @endif
                                    <form action="{{ route('admin.projects.images.delete', $image->id) }}"
                                        method="POST"
                                        class="delete-image-form"
                                        onsubmit="return confirmDelete(event, this);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted text-center py-3">Chưa có ảnh nào. Hãy thêm ảnh cho dự án.</p>
                    @endif
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
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>
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
                                name="is_active" value="1"
                                {{ old('is_active', $project->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Hiển thị trên website
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                        <i class="fas fa-save"></i> Cập nhật Dự án
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Upload Image Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.projects.images.upload', $project) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Thêm ảnh mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_image" class="form-label">Chọn ảnh</label>
                        <input type="file" class="form-control" id="new_image"
                            name="image" accept="image/*" required
                            onchange="previewNewImage(event)">
                        <small class="text-muted">Hỗ trợ: JPG, PNG, WEBP. Tối đa 5MB</small>
                    </div>

                    <!-- Preview -->
                    <div id="newImagePreview"></div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_primary_new"
                            name="is_primary" value="1">
                        <label class="form-check-label" for="is_primary_new">
                            Đặt làm ảnh chính
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="uploadBtn">
                        <i class="fas fa-upload"></i> Tải lên
                    </button>
                </div>
            </form>
        </div>
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

    // Edit form submission
    document.getElementById('editForm').addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }
        isSubmitting = true;
        document.getElementById('loadingOverlay').style.display = 'flex';
        document.getElementById('loadingText').textContent = 'Đang cập nhật...';
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang cập nhật...';
    });

    // Upload form submission
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }
        isSubmitting = true;
        document.getElementById('loadingOverlay').style.display = 'flex';
        document.getElementById('loadingText').textContent = 'Đang tải ảnh lên Cloudinary...';
        document.getElementById('uploadBtn').disabled = true;
        document.getElementById('uploadBtn').innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang tải...';
    });

    // Delete confirmation
    function confirmDelete(e, form) {
        e.preventDefault();

        if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
            document.getElementById('loadingOverlay').style.display = 'flex';
            document.getElementById('loadingText').textContent = 'Đang xóa ảnh...';
            form.submit();
        }

        return false;
    }

    function previewNewImage(event) {
        const preview = document.getElementById('newImagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                <img src="${e.target.result}" class="img-thumbnail mb-3" 
                     style="width: 100%; max-height: 200px; object-fit: contain;">
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