@extends('admin.layouts.app')

@section('title', 'Quản lý Slider Trang chủ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Slider Trang chủ</h2>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Slider
    </a>
</div>

@if($sliders->count() > 0)
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 100px;">Ảnh</th>
                        <th>Tiêu đề</th>
                        <th style="width: 100px;">Thứ tự</th>
                        <th style="width: 100px;">Trạng thái</th>
                        <th style="width: 150px;" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $slider)
                    <tr>
                        <td>
                            <img src="{{ $slider->cloudinary_url }}"
                                alt="{{ $slider->title_vi }}"
                                class="img-thumbnail"
                                style="width: 80px; height: 50px; object-fit: cover;">
                        </td>
                        <td>
                            <div>
                                <strong>{{ $slider->title_vi ?? 'Không có tiêu đề' }}</strong>
                                <br>
                                <small class="text-muted">{{ $slider->subtitle_vi }}</small>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $slider->display_order }}</span>
                        </td>
                        <td class="text-center">
                            @if($slider->is_active)
                            <span class="badge bg-success">Hiển thị</span>
                            @else
                            <span class="badge bg-secondary">Ẩn</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.sliders.edit', $slider) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger delete-btn"
                                    title="Xóa"
                                    data-slider-id="{{ $slider->id }}"
                                    data-slider-title="{{ $slider->title_vi ?? 'Slider này' }}"
                                    data-slider-url="{{ route('admin.sliders.destroy', $slider) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-images fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">Chưa có slider nào</h5>
        <p class="text-muted">Thêm slider đầu tiên cho trang chủ của bạn</p>
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary mt-3">
            <i class="fas fa-plus"></i> Thêm Slider
        </a>
    </div>
</div>
@endif

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger"></i>
                </div>
                <h5 class="text-center mb-3">Bạn có chắc muốn xóa slider này?</h5>
                <div class="alert alert-warning mb-0">
                    <strong><i class="fas fa-info-circle me-1"></i>Slider:</strong>
                    <p class="mb-0 mt-2" id="sliderTitleToDelete"></p>
                </div>
                <p class="text-danger text-center mt-3 mb-0">
                    <small><i class="fas fa-exclamation-circle me-1"></i>Hành động này không thể hoàn tác!</small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Hủy bỏ
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-1"></i>Xóa ngay
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for delete -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('styles')
<style>
    /* Loading overlay for delete action */
    #deleteLoadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .delete-loading-spinner {
        text-align: center;
    }

    .delete-loading-spinner .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    /* Smooth modal animation */
    .modal.fade .modal-dialog {
        transition: transform 0.4s ease-out, opacity 0.4s ease-out;
    }

    .modal.show .modal-dialog {
        animation: modalSlideIn 0.4s ease-out;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Alert animation in modal */
    .alert {
        animation: fadeInScale 0.5s ease-out 0.3s both;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tạo loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'deleteLoadingOverlay';
        loadingOverlay.innerHTML = `
            <div class="delete-loading-spinner">
                <div class="spinner-border text-danger" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-white fw-bold">Đang xóa slider...</p>
            </div>
        `;
        document.body.appendChild(loadingOverlay);

        // Modal và form elements
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteForm = document.getElementById('deleteForm');
        const sliderTitleElement = document.getElementById('sliderTitleToDelete');

        let currentDeleteUrl = '';
        let currentDeleteBtn = null;
        let isDeleting = false;

        // Xử lý click vào nút xóa
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Ngăn chặn nếu đang xóa
                if (isDeleting) {
                    return false;
                }

                const sliderTitle = this.dataset.sliderTitle;
                const deleteUrl = this.dataset.sliderUrl;

                // Lưu thông tin
                currentDeleteUrl = deleteUrl;
                currentDeleteBtn = this;

                // Hiển thị thông tin trong modal
                sliderTitleElement.textContent = sliderTitle;

                // Mở modal
                deleteModal.show();
            });
        });

        // Xử lý confirm delete trong modal
        confirmDeleteBtn.addEventListener('click', function() {
            if (isDeleting) {
                return false;
            }

            isDeleting = true;

            // Disable button và show loading trong modal
            confirmDeleteBtn.disabled = true;
            confirmDeleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xóa...';

            // Disable nút xóa trong table
            if (currentDeleteBtn) {
                currentDeleteBtn.disabled = true;
                currentDeleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            }

            // Đóng modal
            deleteModal.hide();

            // Show loading overlay sau khi modal đóng
            setTimeout(() => {
                loadingOverlay.style.display = 'flex';
            }, 300);

            // Set action và submit form
            deleteForm.action = currentDeleteUrl;
            deleteForm.submit();
        });

        // Reset khi modal đóng
        document.getElementById('deleteModal').addEventListener('hidden.bs.modal', function() {
            if (!isDeleting) {
                confirmDeleteBtn.disabled = false;
                confirmDeleteBtn.innerHTML = '<i class="fas fa-trash me-1"></i>Xóa ngay';
            }
        });
    });
</script>
@endpush

@endsection