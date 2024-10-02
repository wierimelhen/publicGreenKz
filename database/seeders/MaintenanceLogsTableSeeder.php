<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceLogsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('maintenances')->insert([
            [
                'park_id' => 1,
                'contractor_id' => 1,
                'maintenance_type' => 'Обрезка',
                'date_performed' => '2023-07-15',
                'notes' => 'Регулярная обрезка, без проблем',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'park_id' => 1,
                'contractor_id' => 2,
                'maintenance_type' => 'Полив',
                'date_performed' => '2023-06-01',
                'notes' => 'Глубокий полив из-за засушливых условий',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
