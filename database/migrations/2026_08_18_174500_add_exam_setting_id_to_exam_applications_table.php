<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('exam_applications')) {
            Schema::table('exam_applications', function (Blueprint $table) {
                if (!Schema::hasColumn('exam_applications', 'exam_setting_id')) {
                    $table->unsignedBigInteger('exam_setting_id')->nullable()->after('id');
                    $table->index('exam_setting_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('exam_applications')) {
            Schema::table('exam_applications', function (Blueprint $table) {
                if (Schema::hasColumn('exam_applications', 'exam_setting_id')) {
                    $table->dropColumn('exam_setting_id');
                }
            });
        }
    }
};
