<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Services\QuoteService;
use App\Services\ProjectService;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    protected $bookingService;
    protected $quoteService;
    protected $projectService;
    protected $categoryService;

    public function __construct(
        BookingService $bookingService,
        QuoteService $quoteService,
        ProjectService $projectService,
        CategoryService $categoryService
    ) {
        $this->bookingService = $bookingService;
        $this->quoteService = $quoteService;
        $this->projectService = $projectService;
        $this->categoryService = $categoryService;
    }

    /**
     * Get dashboard statistics
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = [
                'pending_bookings_count' => $this->bookingService->getPendingBookings()->count(),
                'pending_quotes_count' => $this->quoteService->getPendingQuotes()->count(),
                'total_projects_count' => $this->projectService->getAllProjects()->count(),
                'total_categories_count' => $this->categoryService->getAllCategories()->count(),
                'recent_bookings' => $this->bookingService->getAllBookings()->take(5),
                'recent_quotes' => $this->quoteService->getAllQuotes()->take(5),
            ];

            return response()->json(['success' => true, 'data' => $stats]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
