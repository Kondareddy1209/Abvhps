<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Grama Seva Dal Active Roster Members.
     */
    public function up(): void
    {
        Schema::create('grama_seva_dal_members', function (Blueprint $table) {
            $table->id();
            
            // Relational Foreign Key mapping directly to the parent row inside grama_seva_dals
            $table->foreignId('grama_seva_dal_id')->constrained('grama_seva_dals')->onDelete('cascade');
            
            // Dynamic Youth Extraction Metrics linked to Core 12-Digit Membership
            $table->string('membership_id', 12)->index();
            $table->string('full_name');
            $table->integer('age');
            $table->string('mobile');
            $table->string('photo_path')->nullable();
            
            // Service Badge Force Status Indicator
            $table->boolean('is_active_force')->default(true); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grama_seva_dal_members');
    }
};
