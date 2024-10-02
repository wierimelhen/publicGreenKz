<?php
use Illuminate\Database\Seeder;
use Database\Seeders\ContractorsTableSeeder;
use Database\Seeders\ParkContractorsTableSeeder;
use Database\Seeders\MaintenanceLogsTableSeeder;
use Database\Seeders\ParkVisitorsTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ContractorsTableSeeder::class,
            ParkContractorsTableSeeder::class,
            MaintenanceLogsTableSeeder::class,
            ParkVisitorsTableSeeder::class,
        ]);
    }
}
