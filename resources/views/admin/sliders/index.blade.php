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
                                <form action="{{ route('admin.sliders.destroy', $slider) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa slider này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
@endsection