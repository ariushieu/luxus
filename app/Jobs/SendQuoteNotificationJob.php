<?php

namespace App\Jobs;

use App\Models\Quote;
use App\Mail\QuoteNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendQuoteNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $quote;

    /**
     * Create a new job instance.
     */
    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send email to client
        Mail::to($this->quote->client_email)
            ->send(new QuoteNotificationMail($this->quote, 'client'));

        // Send email to admin
        $adminEmail = config('mail.admin_email', 'admin@luxus.com');
        Mail::to($adminEmail)
            ->send(new QuoteNotificationMail($this->quote, 'admin'));
    }
}
