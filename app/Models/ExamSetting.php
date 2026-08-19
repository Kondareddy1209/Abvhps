<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSetting extends Model
{
    protected $table = 'exam_settings';

    protected $fillable = [
        'exam_title',
        'exam_type',
        'syllabus_pdf_path',
        'banner_image_path',
        'exam_date_time',
        'exam_center_location',
        'prize_details_json',
        'guidelines',
        'application_fee',
        'status',
    ];

    public function getExamTypeLabelAttribute(): string
    {
        return match ($this->exam_type) {
            'theory' => 'Theory',
            'mcq' => 'MCQ',
            'both' => 'Both (Theory + MCQ)',
            default => 'Not Set'
        };
    }

    public function getPrizesListAttribute(): array
    {
        if (empty($this->prize_details_json)) {
            return [];
        }

        $decoded = is_array($this->prize_details_json)
            ? $this->prize_details_json
            : json_decode($this->prize_details_json, true);

        if (!is_array($decoded)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', $decoded), fn($p) => is_string($p) && $p !== ''));
    }

    protected $casts = [
        'exam_date_time' => 'datetime',
        'application_fee' => 'decimal:2',
    ];

    public function applications()
    {
        return $this->hasMany(ExamApplication::class, 'exam_setting_id');
    }
}
