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
                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
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
@endsection