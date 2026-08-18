<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('membership_id', 12)->unique()->nullable(); // 12-digit automatic code
            $blueprint->string('phone')->unique();
            $blueprint->string('payment_status')->default('pending'); // pending, success
            $blueprint->string('payment_id')->nullable();
            
            // Aadhaar and Application fields (will be updated in next steps)
            $blueprint->string('aadhaar_number', 12)->nullable();
            $blueprint->string('full_name')->nullable();
            $blueprint->string('father_or_husband_name')->nullable();
            $blueprint->string('photo_path')->nullable();
            $blueprint->string('gotram')->nullable();
            $blueprint->string('occupation')->nullable();
            
            // Address details
            $blueprint->text('permanent_address')->nullable();
            $blueprint->text('present_address')->nullable();
            $blueprint->string('pincode', 6)->nullable();
            $blueprint->string('grama_panchayat')->nullable();
            $blueprint->string('mandal')->nullable();
            $blueprint->string('assembly_segment')->nullable();
            $blueprint->string('district')->nullable();
            $blueprint->string('state')->nullable();
            $blueprint->string('country')->default('India');
            
            $blueprint->boolean('is_completed')->default(false); // true when full form is submitted
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
