<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Kala Brundam Master Registry.
     */
    public function up(): void
    {
        Schema::create('kala_brundams', function (Blueprint $table) {
            $table->id();
            
            // Unique Registration ID for the Cultural Team (E.g. ABVHPS-KB-001)
            $table->string('team_registration_id', 30)->unique();
            $table->string('team_name');
            
            // Core Type Configuration (Bhajana, Kolatamu, Nrityamu, Others)
            $table->string('team_type'); 
            $table->string('custom_type_spec')->nullable(); // Dynamic specification input text box value if 'Others' is locked
            $table->string('location');
            
            // ABVHPS Dedicated Cultural Disclaimer Audit Flags
            $table->boolean('disclaimer_accepted')->default(false);
            $table->timestamp('disclaimer_accepted_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kala_brundams');
    }
};
