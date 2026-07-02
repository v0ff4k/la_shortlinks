<?php // database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 * Это главный сидер, который запускает все остальные.
 * Сидеры позволяют заполнять базу данных начальными данными.
 * Они особенно полезны для наполнения тестовой или staging-базы реальными,
 * но не чувствительными данными.
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create(); // Создать 10 пользователей

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Запускаем наш кастомный сидер для пользователей
        $this->call([
            UserSeeder::class,
            // UrlSeeder::class, // Если создадим
            // UrlVisitSeeder::class, // Если создадим
        ]);
    }
}
