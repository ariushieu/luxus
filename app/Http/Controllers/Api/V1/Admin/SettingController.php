<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index(): JsonResponse
    {
        try {
            $settings = $this->settingService->getAllSettings();
            return response()->json(['success' => true, 'data' => $settings]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(StoreSettingRequest $request): JsonResponse
    {
        try {
            $setting = $this->settingService->updateSetting(
                $request->key,
                $request->validated()
            );
            return response()->json(['success' => true, 'data' => $setting], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateSettingRequest $request, string $key): JsonResponse
    {
        try {
            $setting = $this->settingService->updateSetting($key, $request->validated());
            return response()->json(['success' => true, 'data' => $setting]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $key): JsonResponse
    {
        try {
            $this->settingService->deleteSetting($key);
            return response()->json(['success' => true, 'message' => 'Setting deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
