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
        if (Schema::hasTable('exam_settings')) {
            Schema::table('exam_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('exam_settings', 'exam_type')) {
                    $table->string('exam_type', 20)->nullable()->after('exam_title');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('exam_settings')) {
            Schema::table('exam_settings', function (Blueprint $table) {
                if (Schema::hasColumn('exam_settings', 'exam_type')) {
                    $table->dropColumn('exam_type');
                }
            });
        }
    }
};
