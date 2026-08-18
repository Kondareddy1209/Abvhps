<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Grama Seva Dal Master Registry.
     */
    public function up(): void
    {
        Schema::create('grama_seva_dals', function (Blueprint $table) {
            $table->id();
            
            // Unique Official Registration Tracking ID (E.g. ABVHPS-GSD-001 Configuration)
            $table->string('gong_registration_id', 40)->unique();
            
            // Location Demographic Parameters
            $table->string('state');
            $table->string('district');
            $table->string('mandal');
            $table->string('village_or_gp'); // Grama Panchayat or Village name node
            
            // Team Leader Relational Anchor Mapped to Core 12-Digit Membership
            $table->string('leader_membership_id', 12)->index();
            $table->string('leader_name');
            $table->string('leader_mobile');
            
            // Service Charter Dedication Legal Consent Flags
            $table->boolean('charter_accepted')->default(false);
            $table->timestamp('charter_accepted_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grama_seva_dals');
    }
};
