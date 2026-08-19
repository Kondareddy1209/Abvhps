<?php

namespace App\Services;

use App\Models\ExamApplication;
use App\Models\ExamSetting;
use App\Models\FundraisingCampaign;
use App\Models\NotificationLog;
use App\Mail\ExamResultAnnouncementMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * Shared notification service for:
 *   - Exam Result Announcements
 *   - Fundraising Campaign Publications  (future)
 *
 * IMPORTANT RULES:
 *  1. Per-channel idempotency is enforced by the unique index on notification_logs
 *     (event_type + notifiable_type + notifiable_id + channel).
 *     If a log row already exists for that combination, the channel is skipped.
 *
 *  2. MAIL_MAILER=log — mail is written to laravel.log, NOT delivered to a real inbox.
 *     Status recorded as 'logged', not 'sent'.
 *
 *  3. WhatsApp — no provider configured. Status recorded as 'not_configured'.
 *
 *  4. In-App — a notification_log row with channel='in_app' is always created.
 *
 *  5. Notification failure must NEVER roll back or block result publication.
 *     Each channel try/catch is independent.
 */
class NotificationService
{
    private const EVENT_EXAM_RESULT = 'exam_result_announced';
    private const EVENT_CAMPAIGN    = 'campaign_published';

    private const TYPE_EXAM_APP  = ExamApplication::class;
    private const TYPE_CAMPAIGN  = FundraisingCampaign::class;

    // ---------------------------------------------------------------
    // PUBLIC API: Exam Result Announcement
    // ---------------------------------------------------------------

    /**
     * Send result-announcement notifications for one exam application.
     *
     * Returns an associative array describing the outcome per channel:
     *   ['email' => 'logged|skipped|failed', 'whatsapp' => 'not_configured|skipped', 'in_app' => 'created|skipped']
     */
    public function sendExamResultAnnouncement(ExamApplication $application, ExamSetting $exam): array
    {
        $results = [];

        $results['email']    = $this->sendExamResultEmail($application, $exam);
        $results['whatsapp'] = $this->sendExamResultWhatsApp($application, $exam);
        $results['in_app']   = $this->sendExamResultInApp($application, $exam);

        return $results;
    }

    /**
     * Send result notifications for ALL published applicants of a given exam.
     * Only applicants that have result_publication_status = 'published' are processed.
     *
     * Returns aggregated counts per channel.
     */
    public function sendExamResultsForExam(ExamSetting $exam): array
    {
        $applicants = ExamApplication::where('exam_setting_id', $exam->id)
            ->where('result_publication_status', 'published')
            ->get();

        $totals = [
            'email'    => ['logged' => 0, 'skipped' => 0, 'failed' => 0],
            'whatsapp' => ['not_configured' => 0, 'skipped' => 0],
            'in_app'   => ['created' => 0, 'skipped' => 0],
            'processed'=> 0,
        ];

        foreach ($applicants as $application) {
            $channelResults = $this->sendExamResultAnnouncement($application, $exam);

            $totals['processed']++;

            // Aggregate email
            $emailStatus = $channelResults['email'];
            if (isset($totals['email'][$emailStatus])) {
                $totals['email'][$emailStatus]++;
            } else {
                $totals['email']['failed']++;
            }

            // Aggregate whatsapp
            $waStatus = $channelResults['whatsapp'];
            if (isset($totals['whatsapp'][$waStatus])) {
                $totals['whatsapp'][$waStatus]++;
            }

            // Aggregate in_app
            $iaStatus = $channelResults['in_app'];
            if (isset($totals['in_app'][$iaStatus])) {
                $totals['in_app'][$iaStatus]++;
            }
        }

        return $totals;
    }

    // ---------------------------------------------------------------
    // PRIVATE: Per-channel implementations for Exam Results
    // ---------------------------------------------------------------

    private function sendExamResultEmail(ExamApplication $application, ExamSetting $exam): string
    {
        // Per-channel idempotency check
        if (NotificationLog::alreadySent(
            self::TYPE_EXAM_APP,
            $application->id,
            'email',
            self::EVENT_EXAM_RESULT
        )) {
            return 'skipped';
        }

        $logData = [
            'event_type'      => self::EVENT_EXAM_RESULT,
            'notifiable_type' => self::TYPE_EXAM_APP,
            'notifiable_id'   => $application->id,
            'channel'         => 'email',
            'recipient_email' => $application->email,
            'subject'         => 'ABVHPS Exam Results Announced — ' . $exam->exam_title,
            'message'         => 'Result announcement for Hall Ticket: ' . $application->hall_ticket_number,
        ];

        try {
            $mailable = new ExamResultAnnouncementMail(
                candidateName:    $application->full_name,
                examTitle:        $exam->exam_title,
                hallTicketNumber: $application->hall_ticket_number,
                resultsUrl:       route('exam.results_portal'),
            );

            Mail::to($application->email)->send($mailable);

            $status = config('mail.default') === 'log' ? 'logged' : 'sent';

            $this->writeLog(array_merge($logData, [
                'status'            => $status,
                'provider_response' => 'MAIL_MAILER=' . config('mail.default'),
                'sent_at'           => now(),
            ]));

            return $status;

        } catch (\Throwable $e) {
            Log::error('[NotificationService] Exam result email failed', [
                'application_id' => $application->id,
                'error'          => $e->getMessage(),
            ]);

            $this->writeLog(array_merge($logData, [
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
                'sent_at'       => now(),
            ]));

            return 'failed';
        }
    }

    private function sendExamResultWhatsApp(ExamApplication $application, ExamSetting $exam): string
    {
        // Per-channel idempotency check
        if (NotificationLog::alreadySent(
            self::TYPE_EXAM_APP,
            $application->id,
            'whatsapp',
            self::EVENT_EXAM_RESULT
        )) {
            return 'skipped';
        }

        // No WhatsApp provider configured — record accurately
        $message = "ABVHPS Exam Results\n\n"
            . "The results for {$exam->exam_title} have been announced.\n\n"
            . "Hall Ticket Number:\n{$application->hall_ticket_number}\n\n"
            . "Your result is now available on the official ABVHPS website.\n"
            . "Please visit the Exam Results section to view your result.";

        $this->writeLog([
            'event_type'       => self::EVENT_EXAM_RESULT,
            'notifiable_type'  => self::TYPE_EXAM_APP,
            'notifiable_id'    => $application->id,
            'channel'          => 'whatsapp',
            'recipient_mobile' => $application->mobile,
            'subject'          => 'Exam Results — ' . $exam->exam_title,
            'message'          => $message,
            'status'           => 'not_configured',
            'provider_response'=> 'No WhatsApp provider configured in .env',
            'sent_at'          => now(),
        ]);

        return 'not_configured';
    }

    private function sendExamResultInApp(ExamApplication $application, ExamSetting $exam): string
    {
        // Per-channel idempotency check
        if (NotificationLog::alreadySent(
            self::TYPE_EXAM_APP,
            $application->id,
            'in_app',
            self::EVENT_EXAM_RESULT
        )) {
            return 'skipped';
        }

        $message = "The results for {$exam->exam_title} are now available.\n"
            . "Hall Ticket: {$application->hall_ticket_number}\n"
            . "Visit the Exam Results section to view your result.";

        try {
            $this->writeLog([
                'event_type'      => self::EVENT_EXAM_RESULT,
                'notifiable_type' => self::TYPE_EXAM_APP,
                'notifiable_id'   => $application->id,
                'channel'         => 'in_app',
                'recipient_email' => $application->email,
                'subject'         => 'Exam Results Announced — ' . $exam->exam_title,
                'message'         => $message,
                'status'          => 'created',
                'sent_at'         => now(),
            ]);

            return 'created';

        } catch (\Throwable $e) {
            Log::error('[NotificationService] In-app notification failed', [
                'application_id' => $application->id,
                'error'          => $e->getMessage(),
            ]);
            return 'failed';
        }
    }

    // ---------------------------------------------------------------
    // PUBLIC API: Fundraising Campaign Notification (shared channel)
    // ---------------------------------------------------------------

    /**
     * Send campaign-published notifications to a list of recipients.
     * recipients = array of ['email' => '...', 'mobile' => '...', 'name' => '...']
     *
     * NOTE: WhatsApp remains not_configured until a provider is set up.
     * Email with MAIL_MAILER=log is reported as 'logged', not 'sent'.
     */
    public function sendCampaignPublished(FundraisingCampaign $campaign, array $recipients): array
    {
        $totals = [
            'email'    => ['logged' => 0, 'skipped' => 0, 'failed' => 0],
            'whatsapp' => ['not_configured' => 0, 'skipped' => 0],
            'in_app'   => ['created' => 0, 'skipped' => 0],
            'processed'=> 0,
        ];

        foreach ($recipients as $recipient) {
            $recipientId = $recipient['id'] ?? 0; // use a unique recipient ID if available

            // Email channel
            $emailStatus = $this->sendCampaignEmail($campaign, $recipient, $recipientId);
            if (isset($totals['email'][$emailStatus])) {
                $totals['email'][$emailStatus]++;
            }

            // WhatsApp channel
            $waStatus = $this->sendCampaignWhatsApp($campaign, $recipient, $recipientId);
            if (isset($totals['whatsapp'][$waStatus])) {
                $totals['whatsapp'][$waStatus]++;
            }

            // In-App channel
            $iaStatus = $this->sendCampaignInApp($campaign, $recipient, $recipientId);
            if (isset($totals['in_app'][$iaStatus])) {
                $totals['in_app'][$iaStatus]++;
            }

            $totals['processed']++;
        }

        return $totals;
    }

    private function sendCampaignEmail(FundraisingCampaign $campaign, array $recipient, int $recipientId): string
    {
        if (NotificationLog::alreadySent(
            self::TYPE_CAMPAIGN,
            $campaign->id,
            'email',
            self::EVENT_CAMPAIGN . '_' . $recipientId
        )) {
            return 'skipped';
        }

        $logData = [
            'event_type'      => self::EVENT_CAMPAIGN . '_' . $recipientId,
            'notifiable_type' => self::TYPE_CAMPAIGN,
            'notifiable_id'   => $campaign->id,
            'channel'         => 'email',
            'recipient_email' => $recipient['email'] ?? null,
            'subject'         => 'ABVHPS Fundraising Campaign: ' . $campaign->title,
            'message'         => "Fundraising campaign '{$campaign->title}' has been published.",
        ];

        try {
            // Use Mail::raw for campaign notification (no dedicated Mailable needed yet)
            Mail::raw(
                "Dear {$recipient['name']},\n\n"
                . "A new ABVHPS Fundraising Campaign has been launched:\n\n"
                . "{$campaign->title}\n\n"
                . "Visit the ABVHPS website to contribute.\n\n"
                . "Regards,\nABVHPS Administration",
                fn($msg) => $msg
                    ->to($recipient['email'])
                    ->subject('ABVHPS Fundraising Campaign: ' . $campaign->title)
            );

            $status = config('mail.default') === 'log' ? 'logged' : 'sent';

            $this->writeLog(array_merge($logData, [
                'status'  => $status,
                'sent_at' => now(),
            ]));

            return $status;

        } catch (\Throwable $e) {
            Log::error('[NotificationService] Campaign email failed', [
                'campaign_id' => $campaign->id,
                'error'       => $e->getMessage(),
            ]);

            $this->writeLog(array_merge($logData, [
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
                'sent_at'       => now(),
            ]));

            return 'failed';
        }
    }

    private function sendCampaignWhatsApp(FundraisingCampaign $campaign, array $recipient, int $recipientId): string
    {
        $eventKey = self::EVENT_CAMPAIGN . '_' . $recipientId;

        if (NotificationLog::alreadySent(self::TYPE_CAMPAIGN, $campaign->id, 'whatsapp', $eventKey)) {
            return 'skipped';
        }

        $this->writeLog([
            'event_type'       => $eventKey,
            'notifiable_type'  => self::TYPE_CAMPAIGN,
            'notifiable_id'    => $campaign->id,
            'channel'          => 'whatsapp',
            'recipient_mobile' => $recipient['mobile'] ?? null,
            'subject'          => 'Campaign: ' . $campaign->title,
            'message'          => "ABVHPS campaign '{$campaign->title}' has been published.",
            'status'           => 'not_configured',
            'provider_response'=> 'No WhatsApp provider configured in .env',
            'sent_at'          => now(),
        ]);

        return 'not_configured';
    }

    private function sendCampaignInApp(FundraisingCampaign $campaign, array $recipient, int $recipientId): string
    {
        $eventKey = self::EVENT_CAMPAIGN . '_' . $recipientId;

        if (NotificationLog::alreadySent(self::TYPE_CAMPAIGN, $campaign->id, 'in_app', $eventKey)) {
            return 'skipped';
        }

        try {
            $this->writeLog([
                'event_type'      => $eventKey,
                'notifiable_type' => self::TYPE_CAMPAIGN,
                'notifiable_id'   => $campaign->id,
                'channel'         => 'in_app',
                'recipient_email' => $recipient['email'] ?? null,
                'subject'         => 'New Campaign: ' . $campaign->title,
                'message'         => "ABVHPS fundraising campaign '{$campaign->title}' is now active.",
                'status'          => 'created',
                'sent_at'         => now(),
            ]);

            return 'created';

        } catch (\Throwable $e) {
            Log::error('[NotificationService] Campaign in-app failed', ['error' => $e->getMessage()]);
            return 'failed';
        }
    }

    // ---------------------------------------------------------------
    // Private helpers
    // ---------------------------------------------------------------

    /**
     * Write to notification_logs. Silently ignores duplicate-key violations
     * (the unique index is the last line of defence for idempotency).
     */
    private function writeLog(array $data): void
    {
        try {
            NotificationLog::create($data);
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            // Duplicate key — already logged, safe to ignore
            Log::debug('[NotificationService] Duplicate notification log suppressed', $data);
        } catch (\Throwable $e) {
            Log::error('[NotificationService] Failed to write notification log', [
                'error' => $e->getMessage(),
                'data'  => $data,
            ]);
        }
    }
}
