@extends('admin.layouts.app')

@section('title', 'Cấu hình Website')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-cog text-primary me-2"></i> Cấu hình Website</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Cấu hình</li>
                </ol>
            </nav>
        </div>
        <div>
            <button class="btn btn-outline-secondary" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-2"></i>Làm mới
            </button>
        </div>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
    @csrf

    <!-- Info Alert -->
    <div class="alert alert-info mb-4" style="border-left: 4px solid #17a2b8;">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Lưu ý:</strong> Các cài đặt này chỉ hiển thị trên trang <strong>Giới thiệu</strong>.
        Trang chủ và liên hệ sử dụng nội dung cố định trong mã nguồn.
    </div>

    <!-- About Settings Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-info text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Cài đặt Trang Giới Thiệu</h5>
            <p class="mb-0 mt-2" style="font-size: 0.9rem; opacity: 0.9;">
                Các thông tin này sẽ hiển thị trên trang <strong>/about</strong> (Giới thiệu)
            </p>
        </div>
        <div class="card-body">
            @if(isset($settings['about']) && $settings['about']->count() > 0)
            @foreach($settings['about'] as $setting)
            <div class="setting-item mb-4 pb-3 border-bottom">
                <div class="setting-header mb-3">
                    <h6 class="text-info mb-1">
                        <i class="fas fa-{{ $setting->type === 'image' ? 'image' : 'file-alt' }} me-2"></i>
                        {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                    </h6>
                    <small class="text-muted"><code>{{ $setting->key }}</code></small>
                </div>

                @if($setting->type === 'image')
                <!-- Image Upload -->
                <div class="image-upload-container">
                    @if($setting->value_vi)
                    <div class="current-image mb-3">
                        <label class="form-label fw-semibold">Ảnh hiện tại:</label>
                        <div class="position-relative d-inline-block">
                            <img src="{{ $setting->value_vi }}" alt="{{ $setting->key }}"
                                class="img-thumbnail shadow-sm" style="max-height: 250px; border-radius: 8px;">
                        </div>
                    </div>
                    @endif
                    <div class="upload-section">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-upload me-2"></i>Thay đổi ảnh:
                        </label>
                        <input type="file" class="form-control form-control-modern"
                            name="settings[{{ $setting->key }}][image]"
                            accept="image/*"
                            onchange="previewAboutImage(event, '{{ $setting->key }}')">
                        <input type="hidden" name="settings[{{ $setting->key }}][value_vi]" value="{{ $setting->value_vi }}">
                        <small class="text-muted d-block mt-1">
                            <i class="fas fa-info-circle me-1"></i>Định dạng: JPG, PNG, GIF, WEBP - Tối đa 5MB
                        </small>
                        <div id="preview_{{ $setting->key }}" class="mt-3"></div>
                    </div>
                </div>
                @else
                <!-- Text/Textarea Fields -->
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="settings_{{ $setting->key }}_vi" class="form-label fw-semibold">
                            <i class="fas fa-flag me-1"></i>Tiếng Việt
                            @if($setting->key === 'about_intro')<span class="text-danger">*</span>@endif
                        </label>
                        @if($setting->type === 'textarea')
                        <textarea class="form-control form-control-modern"
                            id="settings_{{ $setting->key }}_vi"
                            name="settings[{{ $setting->key }}][value_vi]"
                            rows="4"
                            placeholder="Nhập nội dung tiếng Việt..."
                            {{ $setting->key === 'about_intro' ? 'required' : '' }}>{{ old('settings.' . $setting->key . '.value_vi', $setting->value_vi) }}</textarea>
                        @else
                        <input type="text" class="form-control form-control-modern"
                            id="settings_{{ $setting->key }}_vi"
                            name="settings[{{ $setting->key }}][value_vi]"
                            placeholder="Nhập nội dung tiếng Việt..."
                            value="{{ old('settings.' . $setting->key . '.value_vi', $setting->value_vi) }}">
                        @endif
                    </div>
                    @if($setting->key === 'about_intro')
                    <div class="col-md-12">
                        <label for="settings_{{ $setting->key }}_en" class="form-label fw-semibold">
                            <i class="fas fa-language me-1"></i>English (Tùy chọn)
                        </label>
                        <textarea class="form-control form-control-modern"
                            id="settings_{{ $setting->key }}_en"
                            name="settings[{{ $setting->key }}][value_en]"
                            rows="4"
                            placeholder="Enter English content...">{{ old('settings.' . $setting->key . '.value_en', $setting->value_en) }}</textarea>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
            @else
            <div class="text-center py-5">
                <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                <h5>Chưa có cài đặt</h5>
                <p class="text-muted">Vui lòng chạy seeder để tạo các cài đặt mặc định cho trang giới thiệu.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Save Button -->
    <div class="text-center mt-4 mb-3">
        <button type="submit" class="btn btn-primary-custom btn-lg px-5" id="saveSettingsBtn">
            <i class="fas fa-save me-2"></i>Lưu Tất cả Cài đặt
        </button>
    </div>
</form>

@push('styles')
<style>
    /* ẨNHOÀN TOÀN SCROLLBAR */
    * {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    *::-webkit-scrollbar {
        display: none;
        width: 0;
        height: 0;
    }

    html,
    body {
        overflow-x: hidden;
        overflow-y: auto;
    }

    /* Page Header */
    .page-header h1 {
        color: #2c3e50;
        font-weight: 700;
    }

    .breadcrumb-item a {
        color: #8B6B47;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: #D4AF37;
    }

    /* Nav Pills Styling */
    .nav-pills .nav-link {
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        color: #6c757d;
        padding: 12px 20px;
    }

    .nav-pills .nav-link:hover {
        background-color: rgba(139, 107, 71, 0.1);
        border-color: #8B6B47;
        color: #8B6B47;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #8B6B47 0%, #D4AF37 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(139, 107, 71, 0.3);
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card.shadow-sm {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .card-header {
        border-bottom: none;
        padding: 20px 25px;
        font-weight: 600;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #8B6B47 0%, #D4AF37 100%);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .bg-gradient-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
    }

    /* Setting Item */
    .setting-item {
        transition: all 0.3s ease;
    }

    .setting-item:hover {
        background-color: rgba(139, 107, 71, 0.02);
        border-radius: 8px;
        padding: 15px !important;
        margin: -15px;
        margin-bottom: 15px;
    }

    .setting-item:last-child {
        border-bottom: none !important;
        padding-bottom: 0 !important;
    }

    .setting-header h6 {
        font-weight: 700;
        margin-bottom: 4px;
    }

    .setting-header code {
        background: rgba(139, 107, 71, 0.1);
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11px;
        color: #8B6B47;
    }

    /* Form Controls */
    .form-control-modern {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        border-color: #8B6B47;
        box-shadow: 0 0 0 0.2rem rgba(139, 107, 71, 0.15);
    }

    .form-label {
        color: #495057;
        margin-bottom: 8px;
    }

    .form-label.fw-semibold {
        font-weight: 600;
    }

    /* Image Upload Container */
    .image-upload-container {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        border: 2px dashed #dee2e6;
    }

    .current-image {
        text-align: center;
    }

    .current-image img {
        border: 3px solid #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Button Styling */
    .btn-primary-custom {
        background: linear-gradient(135deg, #8B6B47 0%, #D4AF37 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 14px 40px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(139, 107, 71, 0.3);
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 107, 71, 0.4);
        background: linear-gradient(135deg, #D4AF37 0%, #8B6B47 100%);
    }

    .btn-primary-custom:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* Alert Styling */
    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
    }

    .alert i {
        font-size: 18px;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        10%,
        30%,
        50%,
        70%,
        90% {
            transform: translateX(-5px);
        }

        20%,
        40%,
        60%,
        80% {
            transform: translateX(5px);
        }
    }

    .animate__animated {
        animation-duration: 0.5s;
    }

    .animate__fadeInDown {
        animation-name: fadeInDown;
    }

    .animate__shake {
        animation-name: shake;
    }

    /* Loading Overlay */
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(5px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    #loadingOverlay.show {
        opacity: 1;
    }

    #loadingOverlay .loading-content {
        text-align: center;
        animation: fadeInUp 0.5s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .page-header .d-flex {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 15px;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .nav-pills {
            flex-wrap: nowrap !important;
            overflow-x: auto;
            padding: 12px !important;
        }

        .nav-pills .nav-link {
            white-space: nowrap;
            font-size: 13px;
            padding: 10px 16px !important;
        }

        .card-header h5 {
            font-size: 1.1rem;
        }

        .setting-header h6 {
            font-size: 0.95rem;
        }

        .btn-primary-custom {
            width: 100%;
            padding: 12px 20px;
        }

        .image-upload-container {
            padding: 15px;
        }

        .current-image img {
            max-width: 100%;
            height: auto;
        }
    }

    /* Tablet */
    @media (max-width: 992px) and (min-width: 769px) {
        .page-header h1 {
            font-size: 1.75rem;
        }

        .nav-pills .nav-link {
            font-size: 14px;
            padding: 10px 18px;
        }
    }
</style>

<script>
    console.log('Settings page loaded - v2.0');

    // Form submit with loading overlay
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('settingsForm');

        if (!form) {
            console.error('Form settingsForm not found!');
            return;
        }

        console.log('Form submit handler attached');

        form.addEventListener('submit', function(e) {
            console.log('Form submitting...');

            const btn = document.getElementById('saveSettingsBtn');

            // Disable button only
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang lưu...';

            // Add readonly class to inputs for visual feedback (but don't disable them)
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.style.pointerEvents = 'none';
                input.style.opacity = '0.6';
            });

            // Create loading overlay
            const overlay = document.createElement('div');
            overlay.id = 'loadingOverlay';
            overlay.innerHTML = `
                <div class="loading-content">
                    <div class="spinner-border text-light mb-3" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <h5 class="text-white">Đang cập nhật cài đặt...</h5>
                    <p class="text-white-50">Vui lòng chờ trong giây lát</p>
                </div>
            `;
            document.body.appendChild(overlay);

            // Show overlay with animation
            setTimeout(() => {
                overlay.classList.add('show');
                console.log('Loading overlay shown');
            }, 10);
        });
    });

    // Image preview function
    function previewAboutImage(event, key) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview_' + key);

        if (file) {
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Kích thước file quá lớn! Vui lòng chọn file nhỏ hơn 5MB.');
                event.target.value = '';
                preview.innerHTML = '';
                return;
            }

            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Định dạng file không hợp lệ! Vui lòng chọn file JPG, PNG, GIF hoặc WEBP.');
                event.target.value = '';
                preview.innerHTML = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <div class="alert alert-info">
                        <strong><i class="fas fa-eye me-2"></i>Xem trước ảnh mới:</strong>
                        <div class="mt-2 text-center">
                            <img src="${e.target.result}" class="img-thumbnail shadow-sm" 
                                style="max-height: 250px; border-radius: 8px;">
                        </div>
                        <small class="d-block mt-2 text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Kích thước: ${(file.size / 1024).toFixed(2)} KB
                        </small>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    }

    // Auto dismiss alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endpush
@endsection