@extends('admin.layouts.app')

@section('title', 'Cài đặt Website')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Cài đặt Website</h2>
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

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Settings Tabs -->
    <ul class="nav nav-tabs mb-3" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                data-bs-target="#home" type="button">
                <i class="fas fa-home"></i> Trang Chủ
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="about-tab" data-bs-toggle="tab"
                data-bs-target="#about" type="button">
                <i class="fas fa-info-circle"></i> Trang Giới Thiệu
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                data-bs-target="#contact" type="button">
                <i class="fas fa-phone"></i> Liên Hệ
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="general-tab" data-bs-toggle="tab"
                data-bs-target="#general" type="button">
                <i class="fas fa-cog"></i> Chung
            </button>
        </li>
    </ul>

    <div class="tab-content" id="settingsTabContent">
        <!-- Home Settings -->
        <div class="tab-pane fade show active" id="home" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cài đặt Trang Chủ</h5>
                </div>
                <div class="card-body">
                    @if(isset($settings['home']) && $settings['home']->count() > 0)
                    @foreach($settings['home'] as $setting)
                    <div class="mb-4">
                        <label class="form-label">
                            <strong>{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</strong>
                            <small class="text-muted d-block">{{ $setting->key }}</small>
                        </label>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="settings_{{ $setting->key }}_vi" class="form-label">Tiếng Việt</label>
                                <textarea class="form-control"
                                    id="settings_{{ $setting->key }}_vi"
                                    name="settings[{{ $setting->key }}][value_vi]"
                                    rows="2"
                                    required>{{ old('settings.' . $setting->key . '.value_vi', $setting->value_vi) }}</textarea>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="settings_{{ $setting->key }}_en" class="form-label">English</label>
                                <textarea class="form-control"
                                    id="settings_{{ $setting->key }}_en"
                                    name="settings[{{ $setting->key }}][value_en]"
                                    rows="2">{{ old('settings.' . $setting->key . '.value_en', $setting->value_en) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                    @else
                    <p class="text-muted">Không có cài đặt trang chủ.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- About Settings -->
        <div class="tab-pane fade" id="about" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cài đặt Trang Giới Thiệu</h5>
                </div>
                <div class="card-body">
                    @if(isset($settings['about']) && $settings['about']->count() > 0)
                    @foreach($settings['about'] as $setting)
                    <div class="mb-4">
                        <label class="form-label">
                            <strong>{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</strong>
                            <small class="text-muted d-block">{{ $setting->key }}</small>
                        </label>

                        @if($setting->type === 'image')
                        <!-- Image Upload -->
                        <div class="mb-3">
                            @if($setting->value_vi)
                            <div class="mb-2">
                                <img src="{{ $setting->value_vi }}" alt="{{ $setting->key }}"
                                    class="img-thumbnail" style="max-height: 200px;">
                            </div>
                            @endif
                            <input type="file" class="form-control"
                                name="settings[{{ $setting->key }}][image]"
                                accept="image/*"
                                onchange="previewAboutImage(event, '{{ $setting->key }}')">
                            <input type="hidden" name="settings[{{ $setting->key }}][value_vi]" value="{{ $setting->value_vi }}">
                            <small class="text-muted">Upload ảnh mới hoặc để trống để giữ ảnh hiện tại</small>
                            <div id="preview_{{ $setting->key }}" class="mt-2"></div>
                        </div>
                        @else
                        <!-- Text/Textarea Fields -->
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="settings_{{ $setting->key }}_vi" class="form-label">
                                    Tiếng Việt @if($setting->key === 'about_intro')<span class="text-danger">*</span>@endif
                                </label>
                                @if($setting->type === 'textarea')
                                <textarea class="form-control"
                                    id="settings_{{ $setting->key }}_vi"
                                    name="settings[{{ $setting->key }}][value_vi]"
                                    rows="4"
                                    {{ $setting->key === 'about_intro' ? 'required' : '' }}>{{ old('settings.' . $setting->key . '.value_vi', $setting->value_vi) }}</textarea>
                                @else
                                <input type="text" class="form-control"
                                    id="settings_{{ $setting->key }}_vi"
                                    name="settings[{{ $setting->key }}][value_vi]"
                                    value="{{ old('settings.' . $setting->key . '.value_vi', $setting->value_vi) }}">
                                @endif
                            </div>
                            @if($setting->key === 'about_intro')
                            <div class="col-md-12 mb-2">
                                <label for="settings_{{ $setting->key }}_en" class="form-label">
                                    English (Tùy chọn)
                                </label>
                                <textarea class="form-control"
                                    id="settings_{{ $setting->key }}_en"
                                    name="settings[{{ $setting->key }}][value_en]"
                                    rows="4">{{ old('settings.' . $setting->key . '.value_en', $setting->value_en) }}</textarea>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    <hr>
                    @endforeach
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Chưa có cài đặt cho trang giới thiệu.</strong>
                        <p class="mb-0 mt-2">Vui lòng chạy seeder để tạo các cài đặt mặc định cho trang giới thiệu.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="tab-pane fade" id="contact" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cài đặt Liên Hệ</h5>
                </div>
                <div class="card-body">
                    @if(isset($settings['contact']) && $settings['contact']->count() > 0)
                    @foreach($settings['contact'] as $setting)
                    <div class="mb-4">
                        <label class="form-label">
                            <strong>{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</strong>
                            <small class="text-muted d-block">{{ $setting->key }}</small>
                        </label>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="settings_{{ $setting->key }}_vi" class="form-label">Tiếng Việt</label>
                                @if($setting->key === 'email')
                                <input type="email" class="form-control"
                                    id="settings_{{ $setting->key }}_vi"
                                    name="settings[{{ $setting->key }}][value_vi]"
                                    value="{{ old('settings.' . $setting->key . '.value_vi', $setting->value_vi) }}"
                                    required>
                                @elseif($setting->key === 'phone')
                                <input type="tel" class="form-control"
                                    id="settings_{{ $setting->key }}_vi"
                                    name="settings[{{ $setting->key }}][value_vi]"
                                    value="{{ old('settings.' . $setting->key . '.value_vi', $setting->value_vi) }}"
                                    required>
                                @else
                                <textarea class="form-control"
                                    id="settings_{{ $setting->key }}_vi"
                                    name="settings[{{ $setting->key }}][value_vi]"
                                    rows="2"
                                    required>{{ old('settings.' . $setting->key . '.value_vi', $setting->value_vi) }}</textarea>
                                @endif
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="settings_{{ $setting->key }}_en" class="form-label">English</label>
                                @if($setting->key === 'email')
                                <input type="email" class="form-control"
                                    id="settings_{{ $setting->key }}_en"
                                    name="settings[{{ $setting->key }}][value_en]"
                                    value="{{ old('settings.' . $setting->key . '.value_en', $setting->value_en) }}">
                                @elseif($setting->key === 'phone')
                                <input type="tel" class="form-control"
                                    id="settings_{{ $setting->key }}_en"
                                    name="settings[{{ $setting->key }}][value_en]"
                                    value="{{ old('settings.' . $setting->key . '.value_en', $setting->value_en) }}">
                                @else
                                <textarea class="form-control"
                                    id="settings_{{ $setting->key }}_en"
                                    name="settings[{{ $setting->key }}][value_en]"
                                    rows="2">{{ old('settings.' . $setting->key . '.value_en', $setting->value_en) }}</textarea>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                    @else
                    <p class="text-muted">Không có cài đặt liên hệ.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- General Settings -->
        <div class="tab-pane fade" id="general" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cài đặt Chung</h5>
                </div>
                <div class="card-body">
                    @if(isset($settings['general']) && $settings['general']->count() > 0)
                    @foreach($settings['general'] as $setting)
                    <div class="mb-4">
                        <label class="form-label">
                            <strong>{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</strong>
                            <small class="text-muted d-block">{{ $setting->key }}</small>
                        </label>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="settings_{{ $setting->key }}_vi" class="form-label">Tiếng Việt</label>
                                <textarea class="form-control"
                                    id="settings_{{ $setting->key }}_vi"
                                    name="settings[{{ $setting->key }}][value_vi]"
                                    rows="2"
                                    required>{{ old('settings.' . $setting->key . '.value_vi', $setting->value_vi) }}</textarea>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="settings_{{ $setting->key }}_en" class="form-label">English</label>
                                <textarea class="form-control"
                                    id="settings_{{ $setting->key }}_en"
                                    name="settings[{{ $setting->key }}][value_en]"
                                    rows="2">{{ old('settings.' . $setting->key . '.value_en', $setting->value_en) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                    @else
                    <p class="text-muted">Không có cài đặt chung.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="mt-3">
        <button type="submit" class="btn btn-primary btn-lg" id="saveSettingsBtn">
            <i class="fas fa-save"></i> Lưu Tất cả Cài đặt
        </button>
    </div>
</form>

@push('scripts')
<script>
    // Add loading state to save button
    document.querySelector('form').addEventListener('submit', function(e) {
        const btn = document.getElementById('saveSettingsBtn');
        const originalHtml = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Đang lưu...';

        // Re-enable after 10s in case of error (settings can take longer)
        setTimeout(function() {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        }, 10000);
    });

    function previewAboutImage(event, key) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview_' + key);

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                <label class="form-label">Xem trước:</label>
                <img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px;">
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