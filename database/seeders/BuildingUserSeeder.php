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
                'user_id' => 1
            ],
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
                'user_id' => 4
            ],
            [
                'building_id' => 1,
                'user_id' => 5
            ],
            [
                'building_id' => 1,
                'user_id' => 6
            ],
            [
                'building_id' => 1,
                'user_id' => 7
            ],
            [
                'building_id' => 1,
                'user_id' => 8
            ],
            [
                'building_id' => 1,
                'user_id' => 9
            ],
            [
                'building_id' => 1,
                'user_id' => 10
            ],
            [
                'building_id' => 1,
                'user_id' => 11
            ],
            [
                'building_id' => 1,
                'user_id' => 12
            ],
            [
                'building_id' => 1,
                'user_id' => 13
            ],
        ]);
    }
}