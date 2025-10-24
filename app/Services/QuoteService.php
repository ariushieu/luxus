<?php

namespace App\Services;

use App\Interfaces\QuoteRepositoryInterface;
use App\Jobs\SendQuoteNotificationJob;
use Illuminate\Support\Facades\Log;

class QuoteService
{
    protected $quoteRepository;

    public function __construct(QuoteRepositoryInterface $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    public function getAllQuotes(array $filters = [])
    {
        return $this->quoteRepository->all($filters);
    }

    public function getQuoteById(int $id)
    {
        return $this->quoteRepository->find($id);
    }

    public function createQuote(array $data)
    {
        // Debug: Log incoming data
        Log::info('Creating quote with data:', $data);

        $quote = $this->quoteRepository->create($data);

        // Log created quote
        Log::info('Quote created:', ['id' => $quote->id, 'client_name' => $quote->client_name]);

        // Dispatch job to send email notification
        SendQuoteNotificationJob::dispatch($quote);

        return $quote;
    }
    public function updateQuote(int $id, array $data)
    {
        return $this->quoteRepository->update($id, $data);
    }

    public function updateQuoteStatus(int $id, string $status, ?array $additionalData = null)
    {
        $data = ['status' => $status];

        if ($additionalData) {
            $data = array_merge($data, $additionalData);
        }

        $quote = $this->quoteRepository->update($id, $data);

        // Send notification email when status changes
        SendQuoteNotificationJob::dispatch($quote);

        return $quote;
    }

    public function deleteQuote(int $id)
    {
        return $this->quoteRepository->delete($id);
    }

    public function getPendingQuotes()
    {
        return $this->quoteRepository->getPending();
    }

    public function getQuotesByStatus(string $status)
    {
        return $this->quoteRepository->getByStatus($status);
    }
}
