<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seva_orders_history', function (Blueprint $table) {
            $table->id();
            
            // Unique tracking variable keys connecting to memberships and volunteers rows
            $table->string('member_id', 12)->index(); // Mapped 12 digit member code reference
            $table->string('volunteer_id', 6)->index(); // Mapped 6 digit volunteer code reference
            
            // Log metrics tracking what exact seva was delivered and by which management level
            $table->string('volunteer_role'); // Captured state level position role string
            $table->string('service_type'); // E.g. Free Medical Camp, Cow Protection, Akshara Kits
            
            // Target storage directory routing path for the ultra compressed 1KB-2KB image proof
            $table->string('proof_photo_path'); 
            
            $table->timestamps(); // Automatically records exact date and time metrics of service delivery
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seva_orders_history');
    }
};
