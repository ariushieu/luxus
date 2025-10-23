<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $recipient;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, string $recipient = 'client')
    {
        $this->booking = $booking;
        $this->recipient = $recipient;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->recipient === 'admin'
            ? 'New Booking Request - Luxus Interior Design'
            : 'Booking Confirmation - Luxus Interior Design';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->recipient === 'admin'
            ? 'emails.bookings.admin-notification'
            : 'emails.bookings.client-notification';

        return new Content(
            view: $view,
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
