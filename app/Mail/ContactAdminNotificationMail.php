<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactAdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $email;
    public ?string $phone;
    public $subject;
    public string $messageText;
    public string $source;
    public string $submittedAt;

    public function __construct(array $data)
    {
        $this->name        = $data['name'];
        $this->email       = $data['email'];
        $this->phone       = $data['phone'] ?? null;
        $this->subject     = $data['subject'];
        $this->messageText = $data['message'];
        $this->source      = $data['source'] ?? 'CONTACT_FORM';
        $this->submittedAt = $data['submitted_at'] ?? now()->format('d-M-Y H:i');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[ABVHPS] New Contact Inquiry: ' . $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_admin_notification',
            with: [
                'name'        => $this->name,
                'email'       => $this->email,
                'phone'       => $this->phone,
                'subject'     => $this->subject,
                'messageText' => $this->messageText,
                'source'      => $this->source,
                'submittedAt' => $this->submittedAt,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
