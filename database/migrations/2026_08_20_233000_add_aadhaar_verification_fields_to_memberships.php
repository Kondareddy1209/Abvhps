<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            if (!Schema::hasColumn('memberships', 'is_aadhaar_verified')) {
                $table->boolean('is_aadhaar_verified')->default(false)->after('is_completed');
            }
            if (!Schema::hasColumn('memberships', 'aadhaar_verification_ref')) {
                $table->string('aadhaar_verification_ref')->nullable()->after('is_aadhaar_verified');
            }
            if (!Schema::hasColumn('memberships', 'aadhaar_verified_at')) {
                $table->timestamp('aadhaar_verified_at')->nullable()->after('aadhaar_verification_ref');
            }
        });
    }

    public function down(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('memberships', 'is_aadhaar_verified')) {
                $columns[] = 'is_aadhaar_verified';
            }
            if (Schema::hasColumn('memberships', 'aadhaar_verification_ref')) {
                $columns[] = 'aadhaar_verification_ref';
            }
            if (Schema::hasColumn('memberships', 'aadhaar_verified_at')) {
                $columns[] = 'aadhaar_verified_at';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
