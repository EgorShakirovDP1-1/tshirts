<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
             // Пользователь Egor Shakirov
        User::create([
            'name' => 'Egor',
            'surname' => 'Shakirov',
            'username' => 'Beton_OFF',
            'email' => 'egorsha2005@gmail.com',
            'password' => Hash::make('BtrBmo1981$'),
        ]);

        // Остальные пользователи через фабрику
        User::factory()->count(9)->create();
    }
}
