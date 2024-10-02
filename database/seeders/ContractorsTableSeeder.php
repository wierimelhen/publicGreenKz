<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractorsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('contractors')->insert([
            [
                'name' => 'Зеленые Работы',
                'description' => 'озеленение',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Деревья Уход',
                'description' => 'обслуживание',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
