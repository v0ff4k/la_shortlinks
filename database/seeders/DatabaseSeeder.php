<?php

declare(strict_types=1);
// database/seeders/DatabaseSeeder.php

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
        // Запускаем наш кастомный сидер для пользователей
        $this->call([
            UserSeeder::class,
            // UrlSeeder::class, // Позже создадим
            // UrlVisitSeeder::class, // Позже создадим
        ]);
    }
}
