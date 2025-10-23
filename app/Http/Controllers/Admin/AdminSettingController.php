<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminSettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService,
        protected CloudinaryService $cloudinaryService
    ) {}

    /**
     * Display all settings grouped by category
     */
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Bulk update multiple settings at once
     */
    public function update(Request $request)
    {
        try {
            // Get all settings data
            $settingsData = $request->input('settings', []);

            // Update each setting
            foreach ($settingsData as $key => $data) {
                $setting = Setting::where('key', $key)->first();

                if (!$setting) {
                    continue;
                }

                // Handle image upload for about images
                if ($setting->type === 'image' && $request->hasFile("settings.{$key}.image")) {
                    $image = $request->file("settings.{$key}.image");

                    // Validate image
                    $request->validate([
                        "settings.{$key}.image" => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
                    ]);

                    // Upload to Cloudinary using CloudinaryService
                    $uploadResult = $this->cloudinaryService->uploadImage($image, 'Luxus/settings');

                    // Update setting with image URL
                    $this->settingService->updateSetting($key, [
                        'value_vi' => $uploadResult['url'],
                        'value_en' => $uploadResult['url'],
                    ]);

                    continue; // Skip to next iteration
                }

                // Handle text/textarea fields
                if ($setting->type !== 'image') {
                    // Additional validation based on setting type
                    if ($setting->key === 'email' && isset($data['value_vi']) && !empty($data['value_vi'])) {
                        if (!filter_var($data['value_vi'], FILTER_VALIDATE_EMAIL)) {
                            return back()->withErrors(['settings.' . $key . '.value_vi' => 'Email không hợp lệ!']);
                        }
                    }

                    if ($setting->key === 'phone' && isset($data['value_vi']) && !empty($data['value_vi'])) {
                        if (!preg_match('/^[\d\s\-\+\(\)]+$/', $data['value_vi'])) {
                            return back()->withErrors(['settings.' . $key . '.value_vi' => 'Số điện thoại không hợp lệ!']);
                        }
                    }

                    // Validate required field for about_intro
                    if ($setting->key === 'about_intro' && empty($data['value_vi'])) {
                        return back()->withErrors(['settings.' . $key . '.value_vi' => 'Đoạn giới thiệu (Tiếng Việt) là bắt buộc!']);
                    }

                    // Update via service
                    $this->settingService->updateSetting($key, [
                        'value_vi' => $data['value_vi'] ?? $setting->value_vi,
                        'value_en' => $data['value_en'] ?? $setting->value_en,
                    ]);
                }
            }

            return back()->with('success', 'Cài đặt đã được cập nhật thành công!');
        } catch (\Exception $e) {
            Log::error('Error updating settings: ' . $e->getMessage());
            return back()->with('error', 'Lỗi khi cập nhật cài đặt: ' . $e->getMessage());
        }
    }
}
