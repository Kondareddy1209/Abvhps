<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class VolunteerWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $volunteerData;
    protected ?string $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct(array $volunteerData, ?string $pdfContent = null)
    {
        $this->volunteerData = $volunteerData;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $id = $this->volunteerData['volunteer_id'] ?? ($this->volunteerData['formatted_volunteer_id'] ?? '');
        $subject = !empty($id)
            ? "🎉 ABVHPS Volunteer Approved - Your Volunteer ID: {$id}"
            : "🎉 Welcome to ABVHPS Volunteer Wing - Your ID Card & Credentials";

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.volunteer_welcome',
            with: [
                'volunteerData' => $this->volunteerData,
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
            $rawId = str_replace(' ', '', $this->volunteerData['formatted_volunteer_id'] ?? 'VOLUNTEER');
            $attachments[] = Attachment::fromData(
                fn () => $this->pdfContent,
                'ABVHPS_Volunteer_ID_Card_' . $rawId . '.pdf'
            )->withMime('application/pdf');
        }

        return $attachments;
    }
}
