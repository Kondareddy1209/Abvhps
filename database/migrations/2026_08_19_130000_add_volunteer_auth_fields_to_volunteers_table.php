<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for volunteer login authentication system.
     */
    public function up(): void
    {
        Schema::table('volunteers', function (Blueprint $table) {
            if (!Schema::hasColumn('volunteers', 'volunteer_login_id')) {
                $table->string('volunteer_login_id', 6)->unique()->nullable()->after('volunteer_id');
            }
            if (!Schema::hasColumn('volunteers', 'must_change_password')) {
                $table->boolean('must_change_password')->default(true)->after('password');
            }
            if (!Schema::hasColumn('volunteers', 'remember_token')) {
                $table->rememberToken()->after('must_change_password');
            }
            if (!Schema::hasColumn('volunteers', 'credentials_created_at')) {
                $table->timestamp('credentials_created_at')->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('volunteers', 'welcome_email_sent_at')) {
                $table->timestamp('welcome_email_sent_at')->nullable()->after('credentials_created_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn([
                'volunteer_login_id',
                'must_change_password',
                'remember_token',
                'credentials_created_at',
                'welcome_email_sent_at',
            ]);
        });
    }
};
