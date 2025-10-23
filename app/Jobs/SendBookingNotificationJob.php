<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Mail\BookingNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBookingNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $booking;

    /**
     * Create a new job instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send email to client
        Mail::to($this->booking->client_email)
            ->send(new BookingNotificationMail($this->booking, 'client'));

        // Send email to admin
        $adminEmail = config('mail.admin_email', 'admin@luxus.com');
        Mail::to($adminEmail)
            ->send(new BookingNotificationMail($this->booking, 'admin'));
    }
}
