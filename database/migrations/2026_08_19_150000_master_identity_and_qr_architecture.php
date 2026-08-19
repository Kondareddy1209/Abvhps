<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Clean & Validate Volunteer IDs (Non-sequential randomized 6-digit numbers)
        $volunteers = DB::table('volunteers')->get();
        $assignedIds = [];

        foreach ($volunteers as $vol) {
            $currentId = trim((string)($vol->volunteer_id ?? ''));

            // Check if current ID is already a valid 6-digit numeric string
            if ($currentId !== '' && preg_match('/^[0-9]{6}$/', $currentId) && !in_array($currentId, $assignedIds)) {
                $assignedIds[] = $currentId;
                // Synchronize volunteer_login_id
                DB::table('volunteers')->where('id', $vol->id)->update([
                    'volunteer_login_id' => $currentId,
                    'updated_at' => now(),
                ]);
            } else {
                // If invalid (e.g. RS0001, missing, duplicate, etc.), allocate a randomized unique 6-digit numeric ID
                if ($vol->status === 'approved') {
                    do {
                        $candidate = (string) random_int(100000, 999999);
                    } while (in_array($candidate, $assignedIds) || DB::table('volunteers')->where('volunteer_id', $candidate)->orWhere('volunteer_login_id', $candidate)->exists());

                    $assignedIds[] = $candidate;
                    DB::table('volunteers')->where('id', $vol->id)->update([
                        'volunteer_id' => $candidate,
                        'volunteer_login_id' => $candidate,
                        'updated_at' => now(),
                    ]);
                } else {
                    // For pending/rejected, keep volunteer_id null
                    DB::table('volunteers')->where('id', $vol->id)->update([
                        'volunteer_id' => null,
                        'volunteer_login_id' => null,
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // 2. Ensure schema columns & indexes
        Schema::table('volunteers', function (Blueprint $table) {
            // Indexing for rapid authentication and verification lookup
            if (!Schema::hasColumn('volunteers', 'volunteer_id')) {
                $table->string('volunteer_id', 20)->nullable()->unique()->after('locality');
            }
            if (!Schema::hasColumn('volunteers', 'volunteer_login_id')) {
                $table->string('volunteer_login_id', 20)->nullable()->index()->after('volunteer_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe reversible migration
    }
};
