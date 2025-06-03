<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $likes = [];
        // Предполагаем, что есть хотя бы 10 пользователей и 10 рисунков
        for ($i = 1; $i <= 1000; $i++) {
            $likes[] = [
                'rating' => rand(0, 1) ? 1 : -1, // Случайно 1 или -1
                'user_id' => rand(1, 10),
                'drawing_id' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('likes')->insert($likes);
    }
}
