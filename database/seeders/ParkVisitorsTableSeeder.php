<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParkVisitorsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('park_visitors')->insert([
            [
                'park_id' => 1,
                'scan_time' => now(),
                'visitor_ip' => '192.168.1.100',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'park_id' => 2,
                'scan_time' => now()->subDay(),
                'visitor_ip' => '192.168.1.101',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
