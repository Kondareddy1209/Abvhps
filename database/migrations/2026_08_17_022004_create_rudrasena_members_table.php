<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for Advanced Rudrasena Master Repository.
     */
    public function up(): void
    {
        Schema::create('rudrasena_members', function (Blueprint $table) {
            $table->id();
            
            // Core Relational Anchor Mapped to 12-Digit Membership
            $table->string('membership_id', 12)->index(); 
            $table->string('full_name');
            $table->string('email');
            $table->string('mobile');
            $table->date('dob');
            $table->integer('age');
            $table->string('blood_group')->nullable();
            $table->string('gotram')->nullable();
            
            // 1. Strict Nominee Dataset Elements (Insurance Matrix Target)
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->integer('nominee_age');
            $table->string('nominee_contact');

            // 2. Secured Internal Bank Account Registry
            $table->string('bank_holder_name');
            $table->string('bank_account_number');
            $table->string('bank_ifsc_code');
            $table->string('bank_name_branch');

            // 3. Comprehensive 4 Mandatory Documents Upload Repository
            $table->string('document_health_declaration'); // Doctor Fitness Form
            $table->string('document_family_declaration'); // Signature + 2 Witness Sheet
            $table->string('document_id_proof');           // Aadhaar/Voter Copy
            $table->string('document_bank_proof');         // Passbook/Cancelled Check Copy
            
            // Central Admin Cadder & Prefix ID Elements
            $table->string('rudrasena_id', 20)->nullable()->unique(); // Prefix E.g. RS0001
            $table->string('assigned_cadder')->nullable(); 
            $table->string('assigned_locality')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->boolean('disclaimer_accepted')->default(false);
            $table->timestamp('terms_accepted_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rudrasena_members');
    }
};
