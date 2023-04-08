<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        //DB::table('works')->truncate();
        DB::table('works')->insert([
            [
                'name' => 'Lead Intern',
                'is_eagle_point' => 'NO',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Boys VC',
                'is_eagle_point' => 'NO',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Girls VC',
                'is_eagle_point' => 'NO',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lodge Coord.',
                'is_eagle_point' => 'NO',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Woodlands',
                'is_eagle_point' => 'NO',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tree Nursery Intern',
                'is_eagle_point' => 'NO',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Aquatics Intern',
                'is_eagle_point' => 'NO',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Museum  Intern',
                'is_eagle_point' => 'NO',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Geology  Intern',
                'is_eagle_point' => 'NO',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Recycling Intern',
                'is_eagle_point' => 'NO',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lead EP',
                'is_eagle_point' => 'YES',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'VC',
                'is_eagle_point' => 'YES',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Trail Guide 1',
                'is_eagle_point' => 'YES',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Trail Guide 2',
                'is_eagle_point' => 'YES',
                'type' => 'STAFF',
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
