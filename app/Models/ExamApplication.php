<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamApplication extends Model
{
    protected $table = 'exam_applications';

    protected $guarded = [];

    public function examSetting()
    {
        return $this->belongsTo(ExamSetting::class, 'exam_setting_id');
    }
}
