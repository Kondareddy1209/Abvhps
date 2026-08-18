<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('kala_brundams')) {
            Schema::table('kala_brundams', function (Blueprint $table) {
                if (!Schema::hasColumn('kala_brundams', 'status')) {
                    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                }
                if (!Schema::hasColumn('kala_brundams', 'approved_by_volunteer_id')) {
                    $table->unsignedBigInteger('approved_by_volunteer_id')->nullable();
                }
            });
        }

        if (Schema::hasTable('grama_seva_dals')) {
            Schema::table('grama_seva_dals', function (Blueprint $table) {
                if (!Schema::hasColumn('grama_seva_dals', 'status')) {
                    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                }
                if (!Schema::hasColumn('grama_seva_dals', 'approved_by_volunteer_id')) {
                    $table->unsignedBigInteger('approved_by_volunteer_id')->nullable();
                }
            });
        }

        if (Schema::hasTable('organic_farmers')) {
            Schema::table('organic_farmers', function (Blueprint $table) {
                if (!Schema::hasColumn('organic_farmers', 'status')) {
                    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                }
                if (!Schema::hasColumn('organic_farmers', 'approved_by_volunteer_id')) {
                    $table->unsignedBigInteger('approved_by_volunteer_id')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
    }
};
