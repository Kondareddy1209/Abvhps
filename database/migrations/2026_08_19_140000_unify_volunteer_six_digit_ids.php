<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Backfill all existing volunteers who have non-6-digit IDs (like RS0001) or null IDs
        $volunteers = DB::table('volunteers')->orderBy('id', 'asc')->get();
        $nextId = 100001;

        foreach ($volunteers as $vol) {
            $currentId = $vol->volunteer_id;
            $needsUpdate = false;
            $updates = [];

            if ($vol->status === 'approved') {
                if (empty($currentId) || !preg_match('/^[0-9]{6}$/', trim($currentId))) {
                    while (DB::table('volunteers')->where('volunteer_id', (string)$nextId)->exists()) {
                        $nextId++;
                    }
                    $currentId = (string)$nextId;
                    $updates['volunteer_id'] = $currentId;
                    $needsUpdate = true;
                    $nextId++;
                }

                if (empty($vol->volunteer_login_id) || $vol->volunteer_login_id !== $currentId) {
                    $updates['volunteer_login_id'] = $currentId;
                    $needsUpdate = true;
                }

                if (empty($vol->password)) {
                    $updates['password'] = Hash::make('ABVH@123456');
                    $updates['must_change_password'] = true;
                    $needsUpdate = true;
                }
            } else {
                // For pending/rejected, if they have an RS id or wrong id, clear it until approved
                if (!empty($currentId) && !preg_match('/^[0-9]{6}$/', trim($currentId))) {
                    $updates['volunteer_id'] = null;
                    $updates['volunteer_login_id'] = null;
                    $needsUpdate = true;
                }
            }

            if ($needsUpdate) {
                DB::table('volunteers')->where('id', $vol->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down needed
    }
};
