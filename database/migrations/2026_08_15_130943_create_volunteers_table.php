<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            
            // Linking variables connecting directly to memberships table row tracking
            $table->string('membership_id', 12)->unique();
            $table->string('phone', 10)->unique();
            
            // Core Identity profile metrics fields mapping
            $table->string('qualification');
            $table->string('voter_id_number')->unique();
            $table->string('email')->unique(); // Mandatory for volunteers profile tracking
            
            // Section 1: Detailed Bank Account Information metrics columns
            $table->string('bank_name');
            $table->string('account_holder_name');
            $table->string('account_number');
            $table->string('ifsc_code');
            $table->string('branch_name');
            
            // Section 2: Nominee Emergency Profile Details info rows
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->string('nominee_phone', 10);
            
            // Section 3: Uploaded Physical Document File path routing identifiers
            $table->string('document_declaration_path');
            $table->string('document_voter_path');
            $table->string('document_bank_path');
            
            // Section 4: Dynamic Admin Desk Controls Configuration Layout
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('designation')->nullable(); // Set manually by admin during approval (e.g., Co-ordinator)
            $table->string('locality')->nullable(); // Set manually by admin during approval (e.g., Badvel, A.P State)
            $table->string('volunteer_id', 6)->unique()->nullable(); // 6-digit dynamic random tracking id code (e.g., 662424)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
