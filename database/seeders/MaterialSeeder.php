<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('materials')->insert([
            ['material' => 'Cotton'],
            ['material' => 'Polyester'],
            ['material' => 'Linen'],
            ['material' => 'Wool'],
            ['material' => 'Silk'],
            ['material' => 'Denim'],
            ['material' => 'Leather'],
            ['material' => 'Rayon'],
            ['material' => 'Nylon'],
            ['material' => 'Viscose'],
            ['material' => 'Acrylic'],
            ['material' => 'Velvet'],
            ['material' => 'Jersey'],
            ['material' => 'Satin'],
           
        ]);
    }
}
