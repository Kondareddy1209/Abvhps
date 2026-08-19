<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_messages', 'source')) {
                $table->string('source', 50)->default('CONTACT_FORM')->after('status');
            }
            if (!Schema::hasColumn('contact_messages', 'source_url')) {
                $table->string('source_url', 500)->nullable()->after('source');
            }
            if (!Schema::hasColumn('contact_messages', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('source_url');
            }
            if (!Schema::hasColumn('contact_messages', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('user_agent');
            }
            if (!Schema::hasColumn('contact_messages', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('admin_notes');
            }
            if (!Schema::hasColumn('contact_messages', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('read_at');
            }
        });

        // Extend the status enum to include in_progress and closed
        // SQLite (used in tests) does not support ALTER COLUMN for enums — skip gracefully
        try {
            $driver = DB::connection()->getDriverName();
            if ($driver === 'mysql' || $driver === 'mariadb') {
                DB::statement("ALTER TABLE contact_messages MODIFY COLUMN status ENUM('unread','read','in_progress','replied','closed') NOT NULL DEFAULT 'unread'");
            }
        } catch (\Exception $e) {
            // SQLite / other drivers: status column is string, all values already work
        }
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $cols = ['source', 'source_url', 'user_agent', 'admin_notes', 'read_at', 'replied_at'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('contact_messages', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};

