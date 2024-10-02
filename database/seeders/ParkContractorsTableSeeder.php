<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParkContractorsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('park_contractors')->insert([
            [
                'park_id' => 1,
                'contractor_id' => 1,
                'responsibilities' => 'Озеленение и уход за садом',
                'start_date' => '2023-01-15',
                'end_date' => null, // Все еще активен
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'park_id' => 2,
                'contractor_id' => 2,
                'responsibilities' => 'Обрезка деревьев и уход',
                'start_date' => '2022-03-10',
                'end_date' => '2023-09-01', // Закончил работу
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
