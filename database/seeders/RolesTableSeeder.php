<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'guardian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'professor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
