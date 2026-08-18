<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxCertificate extends Model
{
    protected $table = 'tax_certificates';

    protected $fillable = [
        'title',
        'certificate_type',
        'document_number',
        'valid_from',
        'valid_to',
        'file_path',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'valid_from' => 'date',
        'valid_to' => 'date',
    ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        if (!$this->file_path) {
            return '#';
        }
        if (str_starts_with($this->file_path, 'certifications/')) {
            return asset($this->file_path);
        }
        return asset('storage/' . $this->file_path);
    }
}
