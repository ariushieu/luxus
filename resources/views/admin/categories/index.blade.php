@extends('admin.layouts.app')

@section('title', 'Quản lý Danh mục')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Danh mục</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Danh mục
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tên Danh mục</th>
                        <th>Slug</th>
                        <th style="width: 120px" class="text-center">Số dự án</th>
                        <th style="width: 100px" class="text-center">Trạng thái</th>
                        <th style="width: 150px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>
                            <div>
                                <strong>{{ $category->name_vi }}</strong>
                                <br>
                                <small class="text-muted">{{ $category->name_en }}</small>
                            </div>
                        </td>
                        <td>
                            <code>{{ $category->slug }}</code>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $category->projects_count }}</span>
                        </td>
                        <td class="text-center">
                            @if($category->is_active)
                            <span class="badge bg-success">Hoạt động</span>
                            @else
                            <span class="badge bg-warning">Ẩn</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                                class="btn btn-sm btn-warning"
                                title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button"
                                class="btn btn-sm btn-danger delete-btn"
                                title="Xóa"
                                data-category-id="{{ $category->id }}"
                                data-category-name="{{ $category->name_vi }}"
                                data-category-projects="{{ $category->projects_count }}"
                                data-category-url="{{ route('admin.categories.destroy', $category) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Chưa có danh mục nào. <a href="{{ route('admin.categories.create') }}">Thêm danh mục mới</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa danh mục
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-folder-open fa-3x text-danger"></i>
                </div>
                <h5 class="text-center mb-3">Bạn có chắc muốn xóa danh mục này?</h5>
                <div class="alert alert-warning mb-3">
                    <strong><i class="fas fa-info-circle me-1"></i>Danh mục:</strong>
                    <p class="mb-0 mt-2" id="categoryNameToDelete"></p>
                    <hr class="my-2">
                    <small><strong>Số dự án:</strong> <span id="categoryProjectsCount"></span></small>
                </div>
                <div class="alert alert-danger mb-0" id="warningHasProjects" style="display: none;">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    <strong>Cảnh báo:</strong> Danh mục này đang chứa dự án. Vui lòng xóa hoặc chuyển các dự án sang danh mục khác trước!
                </div>
                <p class="text-danger text-center mt-3 mb-0" id="warningCanDelete">
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
                <p class="mt-3 text-white fw-bold">Đang xóa danh mục...</p>
            </div>
        `;
        document.body.appendChild(loadingOverlay);

        // Modal và form elements
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteForm = document.getElementById('deleteForm');
        const categoryNameElement = document.getElementById('categoryNameToDelete');
        const categoryProjectsElement = document.getElementById('categoryProjectsCount');
        const warningHasProjects = document.getElementById('warningHasProjects');
        const warningCanDelete = document.getElementById('warningCanDelete');

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

                const categoryName = this.dataset.categoryName;
                const projectsCount = parseInt(this.dataset.categoryProjects);
                const deleteUrl = this.dataset.categoryUrl;

                // Lưu thông tin
                currentDeleteUrl = deleteUrl;
                currentDeleteBtn = this;

                // Hiển thị thông tin trong modal
                categoryNameElement.textContent = categoryName;
                categoryProjectsElement.textContent = projectsCount;

                // Kiểm tra nếu có dự án
                if (projectsCount > 0) {
                    warningHasProjects.style.display = 'block';
                    warningCanDelete.style.display = 'none';
                    confirmDeleteBtn.disabled = true;
                    confirmDeleteBtn.innerHTML = '<i class="fas fa-ban me-1"></i>Không thể xóa';
                } else {
                    warningHasProjects.style.display = 'none';
                    warningCanDelete.style.display = 'block';
                    confirmDeleteBtn.disabled = false;
                    confirmDeleteBtn.innerHTML = '<i class="fas fa-trash me-1"></i>Xóa ngay';
                }

                // Mở modal
                deleteModal.show();
            });
        });

        // Xử lý confirm delete trong modal
        confirmDeleteBtn.addEventListener('click', function() {
            if (isDeleting || this.disabled) {
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