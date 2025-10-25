@extends('admin.layouts.app')

@section('title', 'Quản lý Dự án')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Dự án</h2>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Dự án Mới
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 80px">Ảnh</th>
                        <th>Tên Dự án</th>
                        <th style="width: 120px">Danh mục</th>
                        <th style="width: 150px">Địa điểm</th>
                        <th style="width: 80px" class="text-center">Số ảnh</th>
                        <th style="width: 100px" class="text-center">Trạng thái</th>
                        <th style="width: 150px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td>
                            @if($project->primaryImage)
                            <img src="{{ $project->primaryImage->cloudinary_url }}"
                                alt="{{ $project->title_vi }}"
                                class="img-thumbnail"
                                style="width: 60px; height: 60px; object-fit: cover;">
                            @elseif($project->images->isNotEmpty())
                            <img src="{{ $project->images->first()->cloudinary_url }}"
                                alt="{{ $project->title_vi }}"
                                class="img-thumbnail"
                                style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div>
                                <strong>{{ $project->title_vi }}</strong>
                                @if($project->is_featured)
                                <i class="fas fa-star text-warning ms-1" title="Dự án nổi bật"></i>
                                @endif
                                <br>
                                <small class="text-muted">{{ $project->title_en }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $project->category->name_vi }}</span>
                        </td>
                        <td>
                            @if($project->location)
                            <small><i class="fas fa-map-marker-alt text-muted me-1"></i>{{ $project->location }}</small>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $project->images_count }}</span>
                        </td>
                        <td class="text-center">
                            @if($project->is_active)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Hoạt động
                            </span>
                            @else
                            <span class="badge bg-secondary">
                                <i class="fas fa-eye-slash me-1"></i>Ẩn
                            </span>
                            @endif
                            @if($project->is_featured)
                            <br>
                            <span class="badge bg-warning text-dark mt-1">
                                <i class="fas fa-star me-1"></i>Nổi bật
                            </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.projects.edit', $project) }}"
                                class="btn btn-sm btn-warning"
                                title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button"
                                class="btn btn-sm btn-danger delete-btn"
                                title="Xóa"
                                data-project-id="{{ $project->id }}"
                                data-project-title="{{ $project->title_vi }}"
                                data-project-images="{{ $project->images_count }}"
                                data-project-url="{{ route('admin.projects.destroy', $project) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Chưa có dự án nào. <a href="{{ route('admin.projects.create') }}">Thêm dự án mới</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $projects->links() }}
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa dự án
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-building fa-3x text-danger"></i>
                </div>
                <h5 class="text-center mb-3">Bạn có chắc muốn xóa dự án này?</h5>
                <div class="alert alert-warning mb-3">
                    <strong><i class="fas fa-info-circle me-1"></i>Dự án:</strong>
                    <p class="mb-0 mt-2" id="projectTitleToDelete"></p>
                    <hr class="my-2">
                    <small><strong>Số ảnh:</strong> <span id="projectImagesCount"></span></small>
                </div>
                <div class="alert alert-danger mb-0">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    <strong>Cảnh báo:</strong> Tất cả ảnh của dự án sẽ bị xóa khỏi Cloudinary và không thể khôi phục!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Hủy bỏ
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-1"></i>Xóa vĩnh viễn
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
                <p class="mt-3 text-white fw-bold">Đang xóa dự án và ảnh từ Cloudinary...</p>
            </div>
        `;
        document.body.appendChild(loadingOverlay);

        // Modal và form elements
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteForm = document.getElementById('deleteForm');
        const projectTitleElement = document.getElementById('projectTitleToDelete');
        const projectImagesElement = document.getElementById('projectImagesCount');

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

                const projectTitle = this.dataset.projectTitle;
                const imagesCount = parseInt(this.dataset.projectImages);
                const deleteUrl = this.dataset.projectUrl;

                // Lưu thông tin
                currentDeleteUrl = deleteUrl;
                currentDeleteBtn = this;

                // Hiển thị thông tin trong modal
                projectTitleElement.textContent = projectTitle;
                projectImagesElement.textContent = imagesCount;

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
                confirmDeleteBtn.innerHTML = '<i class="fas fa-trash me-1"></i>Xóa vĩnh viễn';
            }
        });
    });
</script>
@endpush

@endsection