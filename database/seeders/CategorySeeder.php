<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['category_name' => 'Abstract'],
            ['category_name' => 'Nature'],
            ['category_name' => 'Animals'],
            ['category_name' => 'People'],
            ['category_name' => 'Technology'],
            ['category_name' => 'Fantasy'],
            ['category_name' => 'Minimalism'],
            ['category_name' => 'Sports'],
            ['category_name' => 'Food'],
            ['category_name' => 'Travel'],
            ['category_name' => 'Music'],
            ['category_name' => 'Art'],
            ['category_name' => 'Comics'],
            ['category_name' => 'Space'],
            ['category_name' => 'Other'],
        ]);
    }
}
