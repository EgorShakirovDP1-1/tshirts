<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParcelMachine;

class ParcelMachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ParcelMachine::insert([
            [
                'name' => 'ParcelBox A1',
                'delivery_price' => 2.99,
                'latitude' => 59.4370,
                'longitude' => 24.7536,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ParcelBox B2',
                'delivery_price' => 3.49,
                'latitude' => 58.3776,
                'longitude' => 26.7290,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
