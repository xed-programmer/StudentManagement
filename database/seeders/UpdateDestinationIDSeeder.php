<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateDestinationIDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendance_visitors')
        ->where('destination', 'MIS')
        ->update(['destination_id' => 1]);

        DB::table('attendance_visitors')
        ->where('destination', 'registrar')
        ->update(['destination_id' => 2]);
    }
}