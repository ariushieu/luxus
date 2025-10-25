<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Services\QuoteService;
use App\Services\SettingService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StoreQuoteRequest;

class ContactController extends Controller
{
    public function __construct(
        protected BookingService $bookingService,
        protected QuoteService $quoteService,
        protected SettingService $settingService
    ) {}

    public function index()
    {
        $settings = $this->settingService->getSettingsByGroup('contact');

        return view('contact', compact('settings'));
    }

    public function storeBooking(StoreBookingRequest $request)
    {
        // Anti-spam: max 3 bookings per email per day
        $dailyBookingsCount = \App\Models\Booking::where('client_email', $request->client_email)
            ->where('created_at', '>=', now()->subDay())
            ->count();

        if ($dailyBookingsCount >= 3) {
            return redirect()->back()
                ->withErrors(['client_email' => 'Bạn đã gửi quá nhiều yêu cầu đặt lịch trong ngày. Vui lòng thử lại sau 24 giờ.'])
                ->withInput();
        }

        $booking = $this->bookingService->createBooking($request->validated());

        return redirect()->back()->with('success', 'Yêu cầu đặt lịch của bạn đã được gửi thành công! Chúng tôi sẽ liên hệ xác nhận trong thời gian sớm nhất.');
    }

    public function storeQuote(StoreQuoteRequest $request)
    {
        // Anti-spam: Check if same email already sent quote for this project recently
        if ($request->filled('project_id')) {
            $recentQuotesCount = \App\Models\Quote::where('client_email', $request->client_email)
                ->where('project_id', $request->project_id)
                ->where('created_at', '>=', now()->subDay())
                ->count();

            if ($recentQuotesCount >= 3) {
                return redirect()->back()
                    ->withErrors(['client_email' => 'Bạn đã gửi quá nhiều yêu cầu báo giá cho dự án này. Vui lòng thử lại sau 24 giờ.'])
                    ->withInput();
            }
        }

        // General spam check: max 5 quotes per email per day
        $dailyQuotesCount = \App\Models\Quote::where('client_email', $request->client_email)
            ->where('created_at', '>=', now()->subDay())
            ->count();

        if ($dailyQuotesCount >= 5) {
            return redirect()->back()
                ->withErrors(['client_email' => 'Bạn đã gửi quá nhiều yêu cầu báo giá trong ngày. Vui lòng thử lại sau 24 giờ.'])
                ->withInput();
        }

        $quote = $this->quoteService->createQuote($request->validated());

        return redirect()->back()->with('success', 'Yêu cầu báo giá của bạn đã được gửi thành công! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.');
    }
}
