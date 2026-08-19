<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_applications', function (Blueprint $table) {
            // Additional result fields not yet in the table
            if (!Schema::hasColumn('exam_applications', 'total_marks')) {
                $table->integer('total_marks')->nullable()->after('marks_obtained');
            }
            if (!Schema::hasColumn('exam_applications', 'grade')) {
                $table->string('grade', 10)->nullable()->after('total_marks');
            }
            if (!Schema::hasColumn('exam_applications', 'result_remarks')) {
                $table->text('result_remarks')->nullable()->after('grade');
            }
            // Draft/publish lifecycle for result announcement
            if (!Schema::hasColumn('exam_applications', 'result_publication_status')) {
                $table->enum('result_publication_status', ['draft', 'published'])
                      ->default('draft')
                      ->after('result_remarks');
            }
            if (!Schema::hasColumn('exam_applications', 'result_published_at')) {
                $table->timestamp('result_published_at')->nullable()->after('result_publication_status');
            }
            // Kept for quick query but NOT used as sole idempotency gate
            // Per-channel idempotency is enforced via notification_logs
            if (!Schema::hasColumn('exam_applications', 'result_notification_sent')) {
                $table->boolean('result_notification_sent')->default(false)->after('result_published_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('exam_applications', function (Blueprint $table) {
            $table->dropColumn([
                'total_marks',
                'grade',
                'result_remarks',
                'result_publication_status',
                'result_published_at',
                'result_notification_sent',
            ]);
        });
    }
};
