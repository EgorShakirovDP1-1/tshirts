<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [];
        // Предполагаем, что есть хотя бы 10 пользователей и 10 рисунков
        $sampleTexts = [
            'Awesome drawing!',
            'Very creative!',
            'Love the colors!',
            'Great job!',
            'Inspiring work!',
            'So beautiful!',
            'Amazing details!',
            'Looks fantastic!',
            'Really cool idea!',
            'Keep it up!',
        ];

        for ($i = 1; $i <= 500; $i++) {
            $comments[] = [
                'user_id' => rand(1, 10),
                'drawing_id' => rand(1, 5),
                'text' => $sampleTexts[array_rand($sampleTexts)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('comments')->insert($comments);
    }
}
