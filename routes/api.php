<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\QuoteController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\V1\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Api\V1\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Api\V1\Admin\QuoteController as AdminQuoteController;
use App\Http\Controllers\Api\V1\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Api\V1\Admin\DashboardController;
use App\Http\Controllers\Api\V1\Admin\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public API Routes (Client Portal)
Route::prefix('v1')->group(function () {

    // Categories - Public
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);

    // Projects - Public
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/featured', [ProjectController::class, 'featured']);
    Route::get('/projects/{slug}', [ProjectController::class, 'show']);
    Route::get('/categories/{categoryId}/projects', [ProjectController::class, 'byCategory']);

    // Settings - Public
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/settings/{key}', [SettingController::class, 'show']);

    // Test settings endpoint (for debugging)
    Route::get('/test-settings', function () {
        $settings = \App\Models\Setting::orderBy('group')->orderBy('key')->get();
        return response()->json([
            'success' => true,
            'total' => $settings->count(),
            'grouped' => $settings->groupBy('group')->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'key' => $item->key,
                        'value_vi' => $item->value_vi,
                        'value_en' => $item->value_en,
                        'type' => $item->type,
                        'updated_at' => $item->updated_at,
                    ];
                });
            })
        ]);
    });

    // Lead Generation - Public
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::post('/quotes', [QuoteController::class, 'store']);
});

// Admin Authentication Routes (Public - for login)
Route::prefix('v1/admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

// Admin API Routes (Protected - requires authentication)
Route::prefix('v1/admin')->middleware('auth:sanctum')->group(function () {

    // Test upload endpoint
    Route::post('/test-upload', function (\Illuminate\Http\Request $request) {
        try {
            $request->validate([
                'image' => 'required|image|max:5120'
            ]);

            $cloudinary = app(\App\Services\CloudinaryService::class);
            $result = $cloudinary->uploadImage($request->file('image'), 'Luxus/test');

            return response()->json([
                'success' => true,
                'message' => 'Upload test successful!',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    });

    // Auth Routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // Categories Management
    Route::apiResource('categories', AdminCategoryController::class)->names([
        'index' => 'api.admin.categories.index',
        'store' => 'api.admin.categories.store',
        'show' => 'api.admin.categories.show',
        'update' => 'api.admin.categories.update',
        'destroy' => 'api.admin.categories.destroy',
    ]);

    // Projects Management
    Route::apiResource('projects', AdminProjectController::class)->names([
        'index' => 'api.admin.projects.index',
        'store' => 'api.admin.projects.store',
        'show' => 'api.admin.projects.show',
        'update' => 'api.admin.projects.update',
        'destroy' => 'api.admin.projects.destroy',
    ]);
    Route::post('/projects/{projectId}/images', [AdminProjectController::class, 'uploadImage'])->name('api.admin.projects.uploadImage');
    Route::delete('/project-images/{imageId}', [AdminProjectController::class, 'deleteImage'])->name('api.admin.projects.deleteImage');

    // Bookings Management
    Route::apiResource('bookings', AdminBookingController::class)->except(['store'])->names([
        'index' => 'api.admin.bookings.index',
        'show' => 'api.admin.bookings.show',
        'update' => 'api.admin.bookings.update',
        'destroy' => 'api.admin.bookings.destroy',
    ]);
    Route::patch('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('api.admin.bookings.updateStatus');
    Route::get('/bookings-pending', [AdminBookingController::class, 'pending'])->name('api.admin.bookings.pending');

    // Quotes Management
    Route::apiResource('quotes', AdminQuoteController::class)->except(['store'])->names([
        'index' => 'api.admin.quotes.index',
        'show' => 'api.admin.quotes.show',
        'update' => 'api.admin.quotes.update',
        'destroy' => 'api.admin.quotes.destroy',
    ]);
    Route::patch('/quotes/{id}/status', [AdminQuoteController::class, 'updateStatus'])->name('api.admin.quotes.updateStatus');
    Route::get('/quotes-pending', [AdminQuoteController::class, 'pending'])->name('api.admin.quotes.pending');

    // Settings Management
    Route::get('/settings', [AdminSettingController::class, 'index']);
    Route::post('/settings', [AdminSettingController::class, 'store']);
    Route::put('/settings/{key}', [AdminSettingController::class, 'update']);
    Route::delete('/settings/{key}', [AdminSettingController::class, 'destroy']);
});
