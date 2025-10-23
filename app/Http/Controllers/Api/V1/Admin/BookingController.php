<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookingRequest;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $filters = [
                'status' => $request->query('status'),
                'from_date' => $request->query('from_date'),
                'to_date' => $request->query('to_date'),
            ];

            $bookings = $this->bookingService->getAllBookings($filters);
            return response()->json(['success' => true, 'data' => $bookings]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $booking = $this->bookingService->getBookingById($id);
            return response()->json(['success' => true, 'data' => $booking]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }
    }

    public function update(UpdateBookingRequest $request, int $id): JsonResponse
    {
        try {
            $booking = $this->bookingService->updateBooking($id, $request->validated());
            return response()->json(['success' => true, 'data' => $booking]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'admin_notes' => 'nullable|string',
        ]);

        try {
            $booking = $this->bookingService->updateBookingStatus(
                $id,
                $request->status,
                $request->admin_notes
            );

            return response()->json(['success' => true, 'data' => $booking]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->bookingService->deleteBooking($id);
            return response()->json(['success' => true, 'message' => 'Booking deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function pending(): JsonResponse
    {
        try {
            $bookings = $this->bookingService->getPendingBookings();
            return response()->json(['success' => true, 'data' => $bookings]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
