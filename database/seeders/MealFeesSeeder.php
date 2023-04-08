<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MealFeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        DB::table('meal_fees')->truncate();
        DB::table('meal_fees')->insert([
            [
                'type' => 'STUDENT',
                'days' => '5',
                'price' => '243.43',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'STUDENT',
                'days' => '4',
                'price' => '243.43',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'STUDENT',
                'days' => '3',
                'price' => '243.43',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'TEACHER',
                'days' => '5',
                'price' => '60',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'TEACHER',
                'days' => '4',
                'price' => '60',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'TEACHER',
                'days' => '3',
                'price' => '60',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'COUNSELOR',
                'days' => '5',
                'price' => '30',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'COUNSELOR',
                'days' => '4',
                'price' => '30',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'COUNSELOR',
                'days' => '3',
                'price' => '30',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
