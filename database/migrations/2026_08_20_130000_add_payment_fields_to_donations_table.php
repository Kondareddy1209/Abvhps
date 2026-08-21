<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to add online payment gateway tracking fields.
     */
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('email')->nullable()->after('contact');
            $table->string('phone')->nullable()->after('email');
            $table->unsignedBigInteger('campaign_id')->nullable()->index()->after('phone');
            $table->string('payment_gateway', 30)->default('manual')->after('about'); // cashfree, razorpay, manual
            $table->string('gateway_order_id')->nullable()->index()->after('payment_gateway');
            $table->string('gateway_payment_id')->nullable()->after('gateway_order_id');
            $table->text('gateway_signature')->nullable()->after('gateway_payment_id');
            $table->string('payment_status', 30)->default('paid')->index()->after('gateway_signature'); // pending, processing, paid, failed, cancelled, refunded
            $table->string('payment_reference')->nullable()->after('payment_status');
            $table->string('receipt_number')->nullable()->unique()->after('payment_reference');
            $table->timestamp('paid_at')->nullable()->after('receipt_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn([
                'email',
                'phone',
                'campaign_id',
                'payment_gateway',
                'gateway_order_id',
                'gateway_payment_id',
                'gateway_signature',
                'payment_status',
                'payment_reference',
                'receipt_number',
                'paid_at',
            ]);
        });
    }
};
