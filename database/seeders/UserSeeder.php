<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();

        DB::table('roles')->insert([
            [
                'name' => 'Super Administrator',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Administrator',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('users')->insert(
            [
                'name' => 'Scicon Admin',
                'first_name' => 'Scicon',
                'last_name' => 'Admin',
                'role_id' => 1,
                'email' => 'scicon@info.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );
    }
}
