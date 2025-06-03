<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('deliveries')->insert([
            [
               
                'drawing_id' => 1,
                'user_id' => 1,
                'parcel_machine_id' => 1,
                'total_price' => 19.99,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
            
                'drawing_id' => 2,
                'user_id' => 2,
                'parcel_machine_id' => 2,
                'total_price' => 24.99,
                'status' => 'shipped',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
            
                'drawing_id' => 3,
                'user_id' => 3,
                'parcel_machine_id' => 3,
                'total_price' => 14.99,
                'status' => 'delivered',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
           
                'drawing_id' => 4,
                'user_id' => 1,
                'parcel_machine_id' => 1,
                'total_price' => 39.99,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
        
                'drawing_id' => 5,
                'user_id' => 2,
                'parcel_machine_id' => 2,
                'total_price' => 29.99,
                'status' => 'cancelled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
