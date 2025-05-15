<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаем 16 пользователей
        User::factory(16)->create();


        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'full_name' => 'Тестовый Пользователь Тестович',
        //     'date_of_birth' => '1990-01-01',
        //     'mobile_phone' => '+79001234567'
        // ]);
    }
}
