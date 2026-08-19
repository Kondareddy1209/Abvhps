<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $table = 'notification_logs';

    protected $fillable = [
        'event_type',
        'notifiable_type',
        'notifiable_id',
        'channel',
        'recipient_email',
        'recipient_mobile',
        'subject',
        'message',
        'status',
        'provider_response',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    /**
     * The owning notifiable entity (polymorphic).
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    // -------------------------------------------------------
    // Scopes
    // -------------------------------------------------------

    public function scopeForEvent($query, string $eventType)
    {
        return $query->where('event_type', $eventType);
    }

    public function scopeForChannel($query, string $channel)
    {
        return $query->where('channel', $channel);
    }

    public function scopeSuccessful($query)
    {
        return $query->whereIn('status', ['sent', 'logged']);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // -------------------------------------------------------
    // Static helpers
    // -------------------------------------------------------

    /**
     * Check if a log entry already exists for this notifiable + channel + event.
     * This is the per-channel idempotency gate.
     */
    public static function alreadySent(
        string $notifiableType,
        int    $notifiableId,
        string $channel,
        string $eventType
    ): bool {
        return static::where('event_type',      $eventType)
                     ->where('notifiable_type', $notifiableType)
                     ->where('notifiable_id',   $notifiableId)
                     ->where('channel',         $channel)
                     ->exists();
    }

    /**
     * Record a notification attempt.
     * If a record already exists (due to the unique index), update it.
     */
    public static function record(array $data): static
    {
        return static::create($data);
    }
}
