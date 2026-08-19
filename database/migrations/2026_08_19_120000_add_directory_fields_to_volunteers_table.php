<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for volunteer directory hierarchy & public visibility.
     */
    public function up(): void
    {
        Schema::table('volunteers', function (Blueprint $table) {
            if (!Schema::hasColumn('volunteers', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('status');
            }
            if (!Schema::hasColumn('volunteers', 'country')) {
                $table->string('country')->nullable()->after('locality');
            }
            if (!Schema::hasColumn('volunteers', 'state')) {
                $table->string('state')->nullable()->after('country');
            }
            if (!Schema::hasColumn('volunteers', 'district')) {
                $table->string('district')->nullable()->after('state');
            }
            if (!Schema::hasColumn('volunteers', 'assembly_segment')) {
                $table->string('assembly_segment')->nullable()->after('district');
            }
            if (!Schema::hasColumn('volunteers', 'mandal')) {
                $table->string('mandal')->nullable()->after('assembly_segment');
            }
            if (!Schema::hasColumn('volunteers', 'grama_panchayat')) {
                $table->string('grama_panchayat')->nullable()->after('mandal');
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
                'is_active',
                'country',
                'state',
                'district',
                'assembly_segment',
                'mandal',
                'grama_panchayat',
            ]);
        });
    }
};
