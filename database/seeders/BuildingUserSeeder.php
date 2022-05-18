<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('building_user')->insert([
            [
                'building_id' => 1,
                'user_id' => 2
            ],
            [
                'building_id' => 1,
                'user_id' => 3
            ],
            [
                'building_id' => 1,
                'user_id' => 5
            ],
            [
                'building_id' => 1,
                'user_id' => 6
            ],
        ]);
    }
}