<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuoteRequest;
use App\Services\QuoteService;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    /**
     * Create a new quote request (Public)
     */
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        try {
            $quote = $this->quoteService->createQuote($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Quote request submitted successfully. Our team will contact you shortly.',
                'data' => $quote,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit quote request',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
