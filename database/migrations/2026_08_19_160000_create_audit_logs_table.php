<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id')->nullable()->index();
            $table->string('actor_type')->nullable(); // e.g. 'Admin', 'Volunteer', 'System', 'Anonymous'
            $table->string('actor_identifier')->nullable()->index(); // e.g. admin email or 6-digit volunteer ID
            $table->string('action', 100)->index(); // e.g. 'ADMIN_LOGIN_SUCCESS', 'VOLUNTEER_APPROVED'
            $table->string('target_type', 100)->nullable()->index(); // e.g. 'Volunteer', 'ExamApplication', 'User'
            $table->string('target_id', 100)->nullable()->index(); // e.g. '583214', 'RS0001', '1'
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable(); // Safe non-sensitive contextual parameters
            $table->timestamp('created_at')->useCurrent()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
