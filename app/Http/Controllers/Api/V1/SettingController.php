<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Get settings by group (Public)
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $group = $request->query('group');
            $locale = $request->query('locale', 'vi');

            // If no group specified, return all settings grouped by group
            if (!$group) {
                $allSettings = $this->settingService->getAllSettings();
                $grouped = $allSettings->groupBy('group')->map(function ($settings) use ($locale) {
                    return $settings->mapWithKeys(function ($setting) use ($locale) {
                        return [$setting->key => [
                            'value' => $setting->getValueByLocale($locale),
                            'type' => $setting->type,
                        ]];
                    });
                });

                return response()->json([
                    'success' => true,
                    'data' => $grouped,
                ]);
            }

            // Return settings for specific group using API format
            $settings = $this->settingService->getSettingsByGroupForApi($group, $locale);

            return response()->json([
                'success' => true,
                'data' => $settings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch settings',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a specific setting by key (Public)
     */
    public function show(Request $request, string $key): JsonResponse
    {
        try {
            $locale = $request->query('locale', 'vi');
            $value = $this->settingService->getSetting($key, $locale);

            if ($value === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Setting not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'key' => $key,
                    'value' => $value,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch setting',
            ], 500);
        }
    }
}
