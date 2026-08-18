<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phone_verifications', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('phone');
            $blueprint->string('otp');
            $blueprint->boolean('is_verified')->default(false);
            $blueprint->timestamp('expired_at');
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phone_verifications');
    }
};
