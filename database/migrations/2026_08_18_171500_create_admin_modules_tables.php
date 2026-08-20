<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Contact Messages Table for Module 13
        if (!Schema::hasTable('contact_messages')) {
            Schema::create('contact_messages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('phone', 20)->nullable();
                $table->string('subject')->nullable();
                $table->text('message');
                $table->string('ip_address', 45)->nullable();
                $table->enum('status', ['unread', 'read', 'replied'])->default('unread');
                $table->timestamps();
            });
        }

        // 2. Tax Compliance Certificates Table for Module 14
        if (!Schema::hasTable('tax_certificates')) {
            Schema::create('tax_certificates', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('certificate_type'); // 12A, 80G, CSR-1, NGO Darpan, Trust Deed, Other
                $table->string('document_number')->nullable();
                $table->date('valid_from')->nullable();
                $table->date('valid_to')->nullable();
                $table->string('file_path');
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 3. Site Settings Table for Module 15
        if (!Schema::hasTable('site_settings')) {
            Schema::create('site_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('group')->default('general');
                $table->timestamps();
            });
        }

        // 4. Update Exam Settings with banner and status if missing
        if (Schema::hasTable('exam_settings')) {
            Schema::table('exam_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('exam_settings', 'banner_image_path')) {
                    $table->string('banner_image_path')->nullable()->after('syllabus_pdf_path');
                }
                if (!Schema::hasColumn('exam_settings', 'status')) {
                    $table->enum('status', ['active', 'upcoming', 'completed'])->default('active')->after('application_fee');
                }
                if (!Schema::hasColumn('exam_settings', 'guidelines')) {
                    $table->text('guidelines')->nullable()->after('prize_details_json');
                }
            });
        }

        // 5. Add status & volunteer approval to Wing tables if missing
        if (Schema::hasTable('kala_brundams')) {
            Schema::table('kala_brundams', function (Blueprint $table) {
                if (!Schema::hasColumn('kala_brundams', 'status')) {
                    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('location');
                }
                if (!Schema::hasColumn('kala_brundams', 'approved_by_volunteer_id')) {
                    $table->unsignedBigInteger('approved_by_volunteer_id')->nullable()->after('status');
                }
            });
        }

        if (Schema::hasTable('grama_seva_dals')) {
            Schema::table('grama_seva_dals', function (Blueprint $table) {
                if (!Schema::hasColumn('grama_seva_dals', 'status')) {
                    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('leader_mobile');
                }
                if (!Schema::hasColumn('grama_seva_dals', 'approved_by_volunteer_id')) {
                    $table->unsignedBigInteger('approved_by_volunteer_id')->nullable()->after('status');
                }
            });
        }

        if (Schema::hasTable('organic_farmers')) {
            Schema::table('organic_farmers', function (Blueprint $table) {
                if (!Schema::hasColumn('organic_farmers', 'status')) {
                    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                }
                if (!Schema::hasColumn('organic_farmers', 'approved_by_volunteer_id')) {
                    $table->unsignedBigInteger('approved_by_volunteer_id')->nullable()->after('status');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('tax_certificates');
        Schema::dropIfExists('contact_messages');
    }
};
