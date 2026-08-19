<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExamResultAnnouncementMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $candidateName;
    public string $examTitle;
    public string $hallTicketNumber;
    public string $resultsUrl;

    /**
     * Per requirement §14: do NOT expose actual marks in the email.
     * Notify candidate only that the result is available.
     */
    public function __construct(
        string $candidateName,
        string $examTitle,
        string $hallTicketNumber,
        string $resultsUrl
    ) {
        $this->candidateName    = $candidateName;
        $this->examTitle        = $examTitle;
        $this->hallTicketNumber = $hallTicketNumber;
        $this->resultsUrl       = $resultsUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ABVHPS Exam Results Announced — ' . $this->examTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.exam_result_announcement',
            with: [
                'candidateName'    => $this->candidateName,
                'examTitle'        => $this->examTitle,
                'hallTicketNumber' => $this->hallTicketNumber,
                'resultsUrl'       => $this->resultsUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
