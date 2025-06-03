<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MaterialSeeder::class,
            CategorySeeder::class,
            ParcelMachineSeeder::class,   // ← сначала ParcelMachineSeeder
            DrawingSeeder::class,         // ← затем DrawingSeeder
            ThingSeeder::class,
                    
            CategoryDrawingSeeder::class,
            LikesSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
