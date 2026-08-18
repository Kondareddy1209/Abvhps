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
        Schema::table('rudrasena_members', function (Blueprint $table) {
            $table->string('volunteer_type')->nullable()->after('mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rudrasena_members', function (Blueprint $table) {
            $table->dropColumn('volunteer_type');
        });
    }
};
