<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
       /**
     * Run the migrations to deploy the core Donations legal financial ledger database table.
     */
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id(); // Unique Serial Key (S.NO Mapping)
            $table->string('name'); // Full Name of the Devotee / Donor
            $table->string('guardian')->nullable(); // Father or Husband Name for legal records
            $table->decimal('amount', 12, 2)->default(0.00); // Precise financial monetary value
            $table->string('pan_number', 10)->nullable(); // Tax Exemption Audit 80G Record
            $table->string('contact'); // Mobile number or official email address of the Donor
            $table->text('about')->nullable(); // Purpose of donation (e.g., Annadhanam, Cow Protection)
            $table->timestamps(); // System automated created_at and updated_at records logs
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
