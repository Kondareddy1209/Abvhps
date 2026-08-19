<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('notification_logs')) {
            Schema::create('notification_logs', function (Blueprint $table) {
                $table->id();

                // Which business event triggered this notification
                // e.g. 'exam_result_announced', 'campaign_published'
                $table->string('event_type', 60);

                // Polymorphic reference to the triggering entity
                // e.g. exam_applications.id / fundraising_campaigns.id
                $table->string('notifiable_type', 100);
                $table->unsignedBigInteger('notifiable_id');

                // Delivery channel
                $table->string('channel', 30); // email | whatsapp | in_app

                // Recipient contact info
                $table->string('recipient_email')->nullable();
                $table->string('recipient_mobile', 20)->nullable();

                // Notification content
                $table->string('subject')->nullable();
                $table->text('message')->nullable();

                // Delivery outcome
                // queued   = dispatched to queue, not yet processed
                // logged   = mail logged to file (MAIL_MAILER=log), not truly sent
                // sent     = confirmed sent by external provider
                // failed   = exception/error during send attempt
                // skipped  = idempotency gate: already sent for this application+channel+event
                // not_configured = provider not set up (e.g. WhatsApp)
                $table->string('status', 20)->default('queued');

                // Raw provider response or log reference
                $table->text('provider_response')->nullable();

                // Error detail if status = failed
                $table->text('error_message')->nullable();

                // Timestamp when delivery was attempted / completed
                $table->timestamp('sent_at')->nullable();

                $table->timestamps();

                // Composite unique index enforces per-application + channel + event idempotency
                $table->unique(
                    ['event_type', 'notifiable_type', 'notifiable_id', 'channel'],
                    'notif_logs_idempotency_idx'
                );

                $table->index(['notifiable_type', 'notifiable_id'], 'notif_logs_notifiable_idx');
                $table->index('status');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
