<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Organic Farmers Master Registry.
     */
    public function up(): void
    {
        Schema::create('organic_farmers', function (Blueprint $table) {
            $table->id();
            
            // Unique Official Registration Tracking ID (E.g. ABVHPS-OF-001 Configuration)
            $table->string('farmer_registration_id', 40)->unique();
            
            // Core Relational Anchor Mapped to 12-Digit Membership
            $table->string('membership_id', 12)->index();
            $table->string('farmer_name');
            $table->string('farmer_mobile');
            
            // Agricultural & Cow-Based Profile Metrics
            $table->decimal('land_size_acres', 5, 2); // Supporting fractional acres (E.g. 2.50 Acres)
            $table->string('water_source');           // Well, Borewell, Canal, Rainfed
            $table->integer('indigenous_cows_count')->default(0); // Number of desi cows owned
            
            // Natural Manure Production Infrastructure Checkboxes Flags
            $table->boolean('uses_jeevamrutham')->default(false);
            $table->boolean('uses_ghana_jeevamrutham')->default(false);
            
            // Pure Organic Oath Pledge Legal Consent Flags
            $table->boolean('organic_oath_accepted')->default(false);
            $table->timestamp('organic_oath_accepted_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organic_farmers');
    }
};
