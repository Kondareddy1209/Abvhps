<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Rudrasena Dynamic Family Structure Nodes.
     */
    public function up(): void
    {
        Schema::create('rudrasena_family_details', function (Blueprint $table) {
            $table->id();
            
            // Relational Foreign Key mapping directly to the master row inside rudrasena_members
            $table->foreignId('rudrasena_member_id')->constrained('rudrasena_members')->onDelete('cascade');
            
            // 6 No's Dynamic Repeater Row Attributes
            $table->string('member_name');
            $table->string('member_relation');
            $table->integer('member_age');
            $table->enum('member_gender', ['Male', 'Female', 'Other']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rudrasena_family_details');
    }
};
