<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('cities')->truncate();
        
        DB::table('cities')->insert([
            [
                'name' => 'Allensworth',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Alpaugh',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Avenal',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Calif Hot Sps',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Corcoran',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Delano',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Dinuba',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Ducor',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Earlimart',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Exeter',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Farmersville',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Goshen',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Hanford',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Ivanhoe',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Kingsburg',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Lemon Cove',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Lindsay',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Lost Hills',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Orosi',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Pixley',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Porterville',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Richgrove',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Shafter',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Springville',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Strathmore',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Sultana',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Terra Bella',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Three Rivers',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Tipton',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Traver',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Tulare',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Visalia',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],    
            [
                'name' => 'Woodlake',
                'state_id' => 1,
                'status' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
