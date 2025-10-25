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

            // Log incoming data for debugging
            Log::info('Settings Update Request', [
                'settings_count' => count($settingsData),
                'has_files' => $request->hasFile('settings')
            ]);

            if (empty($settingsData)) {
                Log::warning('No settings data received');
                return redirect()->back()->with('error', 'Không có dữ liệu cài đặt để cập nhật!');
            }

            $updatedCount = 0;
            $errors = [];

            // Update each setting
            foreach ($settingsData as $key => $data) {
                $setting = Setting::where('key', $key)->first();

                if (!$setting) {
                    Log::warning("Setting not found: {$key}");
                    continue;
                }

                // Handle image upload for about images
                if ($setting->type === 'image' && $request->hasFile("settings.{$key}.image")) {
                    try {
                        $image = $request->file("settings.{$key}.image");

                        // Validate image
                        $validated = $request->validate([
                            "settings.{$key}.image" => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'
                        ]);

                        // Upload to Cloudinary using CloudinaryService
                        $uploadResult = $this->cloudinaryService->uploadImage($image, 'Luxus/settings');

                        // Update setting with image URL
                        $this->settingService->updateSetting($key, [
                            'value_vi' => $uploadResult['url'],
                            'value_en' => $uploadResult['url'],
                        ]);

                        $updatedCount++;
                        Log::info("Updated image setting: {$key}", ['url' => $uploadResult['url']]);
                    } catch (\Exception $e) {
                        $errors[] = "Lỗi upload ảnh {$key}: " . $e->getMessage();
                        Log::error("Image upload failed for {$key}", ['error' => $e->getMessage()]);
                    }

                    continue; // Skip to next iteration
                }

                // Handle text/textarea fields
                if ($setting->type !== 'image') {
                    // Validation
                    if ($setting->key === 'email' && isset($data['value_vi']) && !empty($data['value_vi'])) {
                        if (!filter_var($data['value_vi'], FILTER_VALIDATE_EMAIL)) {
                            $errors[] = "Email không hợp lệ cho {$key}";
                            continue;
                        }
                    }

                    if ($setting->key === 'phone' && isset($data['value_vi']) && !empty($data['value_vi'])) {
                        if (!preg_match('/^[\d\s\-\+\(\)]+$/', $data['value_vi'])) {
                            $errors[] = "Số điện thoại không hợp lệ cho {$key}";
                            continue;
                        }
                    }

                    // Validate required field for about_intro
                    if ($setting->key === 'about_intro' && (!isset($data['value_vi']) || empty(trim($data['value_vi'])))) {
                        $errors[] = "Đoạn giới thiệu (Tiếng Việt) là bắt buộc!";
                        continue;
                    }

                    // Prepare update data - always update both fields
                    $updateData = [
                        'value_vi' => isset($data['value_vi']) ? trim($data['value_vi']) : $setting->value_vi,
                        'value_en' => isset($data['value_en']) ? trim($data['value_en']) : $setting->value_en,
                    ];

                    Log::info("Updating setting: {$key}", $updateData);

                    // Update via service
                    $this->settingService->updateSetting($key, $updateData);
                    $updatedCount++;
                }
            }

            // Return response based on results
            if (!empty($errors)) {
                Log::warning("Settings update completed with errors", ['errors' => $errors]);
                return redirect()->back()
                    ->with('warning', "Cập nhật hoàn tất với một số lỗi. Đã cập nhật {$updatedCount} cài đặt.")
                    ->withErrors($errors);
            }

            Log::info("Settings update completed successfully. Updated {$updatedCount} settings.");
            return redirect()->back()->with('success', "Đã cập nhật thành công {$updatedCount} cài đặt!");
        } catch (\Exception $e) {
            Log::error('Error updating settings: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Lỗi khi cập nhật cài đặt: ' . $e->getMessage())
                ->withInput();
        }
    }
}
