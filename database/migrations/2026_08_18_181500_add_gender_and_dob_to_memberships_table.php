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
        Schema::table('memberships', function (Blueprint $table) {
            if (!Schema::hasColumn('memberships', 'gender')) {
                $table->string('gender')->nullable()->after('full_name');
            }
            if (!Schema::hasColumn('memberships', 'dob')) {
                $table->string('dob')->nullable()->after('gender');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            if (Schema::hasColumn('memberships', 'gender')) {
                $table->dropColumn('gender');
            }
            if (Schema::hasColumn('memberships', 'dob')) {
                $table->dropColumn('dob');
            }
        });
    }
};
