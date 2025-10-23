<?php

namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;
    public $recipient;

    /**
     * Create a new message instance.
     */
    public function __construct(Quote $quote, string $recipient = 'client')
    {
        $this->quote = $quote;
        $this->recipient = $recipient;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->recipient === 'admin'
            ? 'New Quote Request - Luxus Interior Design'
            : 'Quote Request Received - Luxus Interior Design';

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
            ? 'emails.quotes.admin-notification'
            : 'emails.quotes.client-notification';

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
