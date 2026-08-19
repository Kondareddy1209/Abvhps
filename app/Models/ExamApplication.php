<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamApplication extends Model
{
    protected $table = 'exam_applications';

    protected $guarded = [];

    protected $casts = [
        'is_email_verified'        => 'boolean',
        'show_on_winners_wall'     => 'boolean',
        'result_notification_sent' => 'boolean',
        'result_published_at'      => 'datetime',
        'amount_paid'              => 'decimal:2',
    ];

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    public function examSetting()
    {
        return $this->belongsTo(ExamSetting::class, 'exam_setting_id');
    }

    /**
     * Notification logs sent for this application (all channels).
     */
    public function notificationLogs()
    {
        return $this->morphMany(NotificationLog::class, 'notifiable');
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------

    public function isDraft(): bool
    {
        return ($this->result_publication_status ?? 'draft') === 'draft';
    }

    public function isPublished(): bool
    {
        return ($this->result_publication_status ?? 'draft') === 'published';
    }

    /**
     * Computed percentage. Returns null if marks or total not set.
     */
    public function getPercentageAttribute(): ?float
    {
        if ($this->total_marks > 0 && $this->marks_obtained !== null) {
            return round(($this->marks_obtained / $this->total_marks) * 100, 2);
        }
        return null;
    }

    /**
     * Human-readable result outcome label.
     */
    public function getResultOutcomeLabelAttribute(): string
    {
        return match ($this->result_status ?? 'pending') {
            'passed' => 'Pass',
            'failed' => 'Fail',
            default  => 'Pending',
        };
    }
}
