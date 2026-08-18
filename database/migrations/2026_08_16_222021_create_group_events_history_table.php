<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_events_history', function (Blueprint $table) {
            $table->id();
            
            // Core identification fields tracing which exact leader uploaded the group event metrics
            $table->string('volunteer_id', 6)->index(); // Mapped 6 digit volunteer identifier code reference
            $table->string('volunteer_role'); // e.g. village_president, mandal_president position key
            
            // Geography bounding tags mapping exactly where the community mass event happened
            $table->string('mandal');
            $table->string('grama_panchayat')->nullable(); // Can be null if uploaded directly by mandal president level
            
            // Event content tracking properties input by user entry parameters
            $table->string('event_title'); // E.g. Free Annadanam Service, Farmers Awareness Meet, Student Examination
            
            // Target storage directory routing path for the optimized 30KB-50KB image resource asset
            $table->string('group_photo_path'); 
            
            $table->timestamps(); // Automatically records exact date and time metrics of community event delivery
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_events_history');
    }
};
