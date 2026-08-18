<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        /**
     * Run the migrations to deploy the Global Cadre Hierarchy Leadership table.
     */
    public function up(): void
    {
        Schema::create('our_teams', function (Blueprint $table) {
            $table->id(); // Unique Leader Primary Index
            $table->string('membership_id', 12)->nullable()->unique(); // Linked 12-Digit Membership ID if verified via volunteer desk
            $table->string('name'); // Full Official Name of the Leader
            
            // --- STRICT HIERARCHY LEVEL MATRIX ENUM CONFIGURATION ---
            $table->enum('cadre_level', [
                'grama_panchayat', 
                'mandal_level', 
                'assembly_segment', 
                'district_level', 
                'state_level', 
                'national_level', 
                'international_level'
            ])->default('grama_panchayat');

            $table->string('designation'); // Manual typed role (e.g., President, Vice Chairman, Secretary)
            $table->string('locality'); // Specific jurisdiction assigned region (e.g., Palakollu, Kadapa, USA)
            $table->string('image_path')->nullable(); // Profile Photo Storage Destination Directory Locator
            $table->timestamps(); // System automated created_at and updated_at records logs
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_teams');
    }
};
