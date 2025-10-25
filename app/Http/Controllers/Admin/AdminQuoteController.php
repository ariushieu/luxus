<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Services\QuoteService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminQuoteController extends Controller
{
    public function __construct(
        protected QuoteService $quoteService
    ) {}

    /**
     * Display listing of quotes with optional status filter
     */
    public function index(Request $request)
    {
        $query = Quote::query()->latest();

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $quotes = $query->paginate(10);

        // Get counts for filter tabs
        $statusCounts = [
            'all' => Quote::count(),
            'pending' => Quote::where('status', 'pending')->count(),
            'reviewing' => Quote::where('status', 'reviewing')->count(),
            'quoted' => Quote::where('status', 'quoted')->count(),
            'accepted' => Quote::where('status', 'accepted')->count(),
            'rejected' => Quote::where('status', 'rejected')->count(),
        ];

        return view('admin.quotes.index', compact('quotes', 'statusCounts'));
    }

    /**
     * Display detailed quote information
     */
    public function show(Quote $quote)
    {
        return view('admin.quotes.show', compact('quote'));
    }

    /**
     * Update quote status with optional amount and notes
     */
    public function updateStatus(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['pending', 'reviewing', 'quoted', 'accepted', 'rejected'])
            ],
            'quoted_amount' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        // Require quoted_amount when status is 'quoted'
        if ($validated['status'] === 'quoted' && empty($validated['quoted_amount'])) {
            return back()->withErrors(['quoted_amount' => 'Vui lòng nhập số tiền báo giá!']);
        }

        try {
            // Update via service
            $this->quoteService->updateQuote($quote->id, $validated);

            return back()->with('success', 'Trạng thái báo giá đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi cập nhật: ' . $e->getMessage());
        }
    }
}
