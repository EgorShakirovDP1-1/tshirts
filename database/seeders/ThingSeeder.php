<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('things')->insert([
            [
            
                'path_to_img' => 'things/classic_tshirt.jpg',
                'material_id' => 1,
                'drawing_id' => 1,
                'user_id' => 1,
            ],
            [
                
                'path_to_img' => 'things/denim_jacket.jpg',
                'material_id' => 6,
                'drawing_id' => 2,
                'user_id' => 2,
            ],
            [
                
                'path_to_img' => 'things/silk_scarf.jpg',
                'material_id' => 5,
                'drawing_id' => 3,
                'user_id' => 1,
            ],
            [
                
                'path_to_img' => 'things/wool_sweater.jpg',
                'material_id' => 4,
                'drawing_id' => 4,
                'user_id' => 3,
            ],
            [
                
                'path_to_img' => 'things/polyester_shorts.jpg',
                'material_id' => 2,
                'drawing_id' => 5,
                'user_id' => 2,
            ],
        ]);
    }
}
