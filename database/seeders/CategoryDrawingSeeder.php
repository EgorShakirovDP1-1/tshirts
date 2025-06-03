<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryDrawingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Пример: 5 рисунков, 5 категорий, некоторые рисунки в нескольких категориях
        $data = [
            ['drawing_id' => 1, 'category_id' => 1],
            ['drawing_id' => 1, 'category_id' => 2],
            ['drawing_id' => 2, 'category_id' => 2],
            ['drawing_id' => 2, 'category_id' => 3],
            ['drawing_id' => 3, 'category_id' => 3],
            ['drawing_id' => 3, 'category_id' => 4],
            ['drawing_id' => 4, 'category_id' => 4],
            ['drawing_id' => 4, 'category_id' => 5],
            ['drawing_id' => 5, 'category_id' => 1],
            ['drawing_id' => 5, 'category_id' => 5],
        ];

        DB::table('category_drawing')->insert($data);
    }
}
