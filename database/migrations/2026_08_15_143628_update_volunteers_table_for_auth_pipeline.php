<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('volunteers', function (Blueprint $table) {
            // Adding secure password column after email safely
            $table->string('password')->nullable()->after('email');
            
            // Adding high security structural hierarchy role mapping column after status
            // Supported values layout tracking: village_president, mandal_president, assembly_president, district_president, central_admin
            $table->string('role')->default('village_president')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn(['password', 'role']);
        });
    }
};
