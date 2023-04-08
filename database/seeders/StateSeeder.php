<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('countries')->truncate();
        DB::table('states')->truncate();
        
        DB::table('countries')->insert(
            [
                'id' => 1,
                'name' => 'United States of America',
                'code' => 'US',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('states')->insert(
            [
                'id' => 1,
                'name' => 'California',
                'code' => 'CA',
                'country_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );
    }
}
