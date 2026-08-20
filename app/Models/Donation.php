<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Donation extends Model
{
    /**
     * The official database table associated with the model.
     *
     * @var string
     */
    protected $table = 'donations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'guardian',
        'amount',
        'pan_number',
        'contact',
        'email',
        'phone',
        'campaign_id',
        'about',
        'payment_gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'gateway_signature',
        'payment_status',
        'payment_reference',
        'receipt_number',
        'paid_at',
    ];

    /**
     * Attribute casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Associated fundraising campaign if designated.
     */
    public function campaign()
    {
        return $this->belongsTo(FundraisingCampaign::class, 'campaign_id');
    }

    /**
     * Scope for paid donations only.
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Generate unique official receipt number.
     */
    public static function generateReceiptNumber(int $id): string
    {
        return 'ABVHPS-RCP-' . date('Y') . '-' . str_pad($id, 6, '0', STR_PAD_LEFT);
    }
}
