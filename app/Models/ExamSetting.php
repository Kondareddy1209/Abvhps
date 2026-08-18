<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSetting extends Model
{
    protected $table = 'exam_settings';

    protected $fillable = [
        'exam_title',
        'syllabus_pdf_path',
        'banner_image_path',
        'exam_date_time',
        'exam_center_location',
        'prize_details_json',
        'guidelines',
        'application_fee',
        'status',
    ];

    protected $casts = [
        'exam_date_time' => 'datetime',
        'application_fee' => 'decimal:2',
    ];

    public function applications()
    {
        return $this->hasMany(ExamApplication::class, 'exam_setting_id');
    }
}
