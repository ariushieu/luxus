<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminBookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    /**
     * Display listing of bookings with optional status filter
     */
    public function index(Request $request)
    {
        $query = Booking::query()->latest();

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10);

        // Get counts for filter tabs
        $statusCounts = [
            'all' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'statusCounts'));
    }

    /**
     * Display detailed booking information
     */
    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update booking status with optional notes
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])
            ],
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        try {
            // Update via service
            $this->bookingService->updateBooking($booking->id, $validated);

            return back()->with('success', 'Trạng thái lịch hẹn đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi cập nhật: ' . $e->getMessage());
        }
    }
}
