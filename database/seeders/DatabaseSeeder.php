<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with core admin credentials.
     */
    public function run(): void
    {
        // Truncate existing users if any to prevent email collision errors
        DB::table('users')->truncate();

        // Inject official corporate administrative commander profile metrics
        DB::table('users')->insert([
            'name' => 'ABVHPS COMMANDER',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'), // Cryptographically locked security passphrase
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
