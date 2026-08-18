<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Kala Brundam Bound Members Registry.
     */
    public function up(): void
    {
        Schema::create('kala_brundam_members', function (Blueprint $table) {
            $table->id();
            
            // Relational Foreign Key mapping directly to the parent row inside kala_brundams
            $table->foreignId('kala_brundam_id')->constrained('kala_brundams')->onDelete('cascade');
            
            // Dynamic Member Extraction Metrics linked to Core 12-Digit Membership
            $table->string('membership_id', 12)->index();
            $table->string('full_name');
            $table->integer('age');
            $table->string('mobile');
            $table->string('photo_path')->nullable();
            
            // Explicit Verified Status Seal Node for Individual Team Certificate Array
            $table->boolean('is_verified')->default(true); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kala_brundam_members');
    }
};
