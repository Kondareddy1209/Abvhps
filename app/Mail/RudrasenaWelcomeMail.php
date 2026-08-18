<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class RudrasenaWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $memberData;
    protected ?string $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct(array $memberData, ?string $pdfContent = null)
    {
        $this->memberData = $memberData;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $rudrasenaId = $this->memberData['rudrasena_id'] ?? 'MEMBER';
        return new Envelope(
            subject: "🔱 Welcome to ABVHPS Rudrasena Dal - Your ID Card ({$rudrasenaId})",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.rudrasena_welcome',
            with: [
                'memberData' => $this->memberData,
                'pdf_attached' => !empty($this->pdfContent),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if (!empty($this->pdfContent)) {
            $rawId = str_replace(' ', '', $this->memberData['rudrasena_id'] ?? 'RUDRASENA');
            $attachments[] = Attachment::fromData(
                fn () => $this->pdfContent,
                'ABVHPS_Rudrasena_ID_Card_' . $rawId . '.pdf'
            )->withMime('application/pdf');
        }

        return $attachments;
    }
}
