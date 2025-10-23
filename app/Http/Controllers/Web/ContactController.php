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
        $booking = $this->bookingService->createBooking($request->validated());

        return redirect()->back()->with('success', 'Yêu cầu đặt lịch của bạn đã được gửi thành công!');
    }

    public function storeQuote(StoreQuoteRequest $request)
    {
        $quote = $this->quoteService->createQuote($request->validated());

        return redirect()->back()->with('success', 'Yêu cầu báo giá của bạn đã được gửi thành công!');
    }
}
