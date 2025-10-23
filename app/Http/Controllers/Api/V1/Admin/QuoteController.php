<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateQuoteRequest;
use App\Services\QuoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $filters = [
                'status' => $request->query('status'),
                'project_type' => $request->query('project_type'),
            ];

            $quotes = $this->quoteService->getAllQuotes($filters);
            return response()->json(['success' => true, 'data' => $quotes]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $quote = $this->quoteService->getQuoteById($id);
            return response()->json(['success' => true, 'data' => $quote]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Quote not found'], 404);
        }
    }

    public function update(UpdateQuoteRequest $request, int $id): JsonResponse
    {
        try {
            $quote = $this->quoteService->updateQuote($id, $request->validated());
            return response()->json(['success' => true, 'data' => $quote]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,reviewing,quoted,accepted,rejected',
            'admin_notes' => 'nullable|string',
            'quoted_amount' => 'nullable|numeric|min:0',
        ]);

        try {
            $additionalData = [
                'admin_notes' => $request->admin_notes,
                'quoted_amount' => $request->quoted_amount,
            ];

            $quote = $this->quoteService->updateQuoteStatus(
                $id,
                $request->status,
                array_filter($additionalData)
            );

            return response()->json(['success' => true, 'data' => $quote]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->quoteService->deleteQuote($id);
            return response()->json(['success' => true, 'message' => 'Quote deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function pending(): JsonResponse
    {
        try {
            $quotes = $this->quoteService->getPendingQuotes();
            return response()->json(['success' => true, 'data' => $quotes]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
