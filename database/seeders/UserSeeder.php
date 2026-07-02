<?php // database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserSeeder
 * Сидер для создания конкретных пользователей (например, администратора или тестового пользователя).
 * @package Database\Seeders
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем администратора
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret_password_here'), // Не забудьте изменить!
            'email_verified_at' => now(),
        ]);

        // Создаем обычного пользователя
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Или создаем несколько случайных пользователей через фабрику
        User::factory()->count(5)->create(); // Создаст 5 пользователей с данными из фабрики
    }
}
