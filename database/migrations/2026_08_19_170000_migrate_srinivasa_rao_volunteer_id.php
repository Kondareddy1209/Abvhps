<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations to securely migrate SRINIVASA RAO's legacy Volunteer ID 100001
     * to a unique randomized 6-digit numeric ID, set default password to 'password' (hashed),
     * and enforce first-login password change.
     */
    public function up(): void
    {
        $volunteer = DB::table('volunteers')
            ->leftJoin('memberships', 'volunteers.membership_id', '=', 'memberships.membership_id')
            ->where('volunteers.volunteer_id', '100001')
            ->orWhere('memberships.full_name', 'LIKE', '%SRINIVASA RAO%')
            ->select('volunteers.id', 'volunteers.membership_id', 'volunteers.volunteer_id', 'memberships.full_name')
            ->first();

        if ($volunteer && $volunteer->volunteer_id === '100001') {
            // Generate a guaranteed unique randomized 6-digit numeric ID
            $newVolunteerId = null;
            do {
                $candidate = (string) random_int(100000, 999999);
                $exists = DB::table('volunteers')
                    ->where('volunteer_id', $candidate)
                    ->orWhere('volunteer_login_id', $candidate)
                    ->exists();

                if (!$exists) {
                    $newVolunteerId = $candidate;
                }
            } while ($newVolunteerId === null);

            // Update volunteer record with synchronized ID and hashed default password
            DB::table('volunteers')->where('id', $volunteer->id)->update([
                'volunteer_id' => $newVolunteerId,
                'volunteer_login_id' => $newVolunteerId,
                'password' => Hash::make('password'),
                'must_change_password' => true,
                'status' => 'approved',
                'is_active' => true,
                'updated_at' => now(),
            ]);

            Log::info("Migrated Volunteer SRINIVASA RAO from 100001 to new randomized 6-digit ID: {$newVolunteerId}");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // One-way security migration: legacy sequential IDs are not restored
    }
};
