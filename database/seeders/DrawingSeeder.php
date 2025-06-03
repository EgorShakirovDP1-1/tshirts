<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrawingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('drawings')->insert([
            [
                'name' => 'Sunset in the Mountains',
                'path_to_drawing' => 'drawings/sunset_mountains.jpg',
                'user_id' => 1,
 
            ],
            [
                'name' => 'Abstract Shapes',
                'path_to_drawing' => 'drawings/abstract_shapes.png',
                'user_id' => 2,

            ],
            [
                'name' => 'Forest Animals',
                'path_to_drawing' => 'drawings/forest_animals.webp',
                'user_id' => 1,

            ],
            [
                'name' => 'City Skyline',
                'path_to_drawing' => 'drawings/city_skyline.jpg',
                'user_id' => 3,

            ],
            [
                'name' => 'Space Adventure',
                'path_to_drawing' => 'drawings/space_adventure.png',
                'user_id' => 2,

            ],
        ]);
    }
}
