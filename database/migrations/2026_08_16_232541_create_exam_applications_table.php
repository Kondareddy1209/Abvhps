<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('exam_applications', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_email_verified')->default(false);
            $table->string('full_name')->nullable();
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('aadhaar_no')->nullable();
            
            // Parent or Guardian strict structural logic
            $table->enum('guardian_type', ['parents', 'guardian'])->default('parents');
            $table->string('father_membership_id', 12)->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_membership_id', 12)->nullable();
            $table->string('mother_name')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relationship')->nullable();
            $table->string('guardian_mobile_or_id')->nullable();

            // Educational structure
            $table->string('school_college_name')->nullable();
            $table->string('class_section')->nullable();

            // Verification uploads budget
            $table->string('photo_path')->nullable(); // Enforced 1KB-2KB target
            $table->string('id_card_or_signature_path')->nullable();
            $table->string('aadhaar_proof_path')->nullable();

            // Anti-fraud payment & ticket verification desk
            $table->decimal('amount_paid', 8, 2)->default(0.00);
            $table->string('payment_transaction_id')->nullable();
            $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('hall_ticket_number', 11)->unique()->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_applications');
    }
}
