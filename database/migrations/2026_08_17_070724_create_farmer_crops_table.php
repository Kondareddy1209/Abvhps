<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Farmer Bound Crops Matrix Registry.
     */
    public function up(): void
    {
        Schema::create('farmer_crops', function (Blueprint $table) {
            $table->id();
            
            // Relational Foreign Key mapping directly to the parent row inside organic_farmers
            $table->foreignId('organic_farmer_id')->constrained('organic_farmers')->onDelete('cascade');
            
            // Crop Configuration Metrics
            $table->string('crop_name'); // E.g. Paddy, Pulses, Vegetables, Fruits, Millets
            $table->string('variety_spec')->nullable(); // Optional specific traditional variety (E.g. Navara, Indrayani)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_crops');
    }
};
