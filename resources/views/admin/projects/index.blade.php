@extends('admin.layouts.app')

@section('title', 'Quản lý Dự án')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Dự án</h2>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Dự án Mới
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

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 80px">Ảnh</th>
                        <th>Tên Dự án</th>
                        <th>Danh mục</th>
                        <th>Địa điểm</th>
                        <th style="width: 100px" class="text-center">Số ảnh</th>
                        <th style="width: 100px" class="text-center">Trạng thái</th>
                        <th style="width: 150px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td>
                            @if($project->primary_image)
                            <img src="{{ $project->primary_image->cloudinary_url }}"
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
                                <br>
                                <small class="text-muted">{{ $project->title_en }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $project->category->name_vi }}</span>
                        </td>
                        <td>{{ $project->location ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $project->images_count }}</span>
                        </td>
                        <td class="text-center">
                            @if($project->is_active)
                            <span class="badge bg-success">Hoạt động</span>
                            @else
                            <span class="badge bg-warning">Ẩn</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.projects.edit', $project) }}"
                                class="btn btn-sm btn-warning"
                                title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Bạn có chắc muốn xóa dự án này?');">
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
@endsection