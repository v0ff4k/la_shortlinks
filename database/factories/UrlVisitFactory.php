<?php // database/factories/UrlVisitFactory.php

namespace Database\Factories;

use App\Domains\Analytics\Models\UrlVisit;
use App\Domains\Url\Models\Url; // Предполагаем связь с URL
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для создания записей о посещениях (UrlVisit).
 * @extends Factory<UrlVisit>
 */
class UrlVisitFactory extends Factory
{
    protected $model = UrlVisit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url_id' => Url::factory(), // Создаст случайный URL, если не указан
            'ip_address' => fake()->ipv4(), // Или ipv6() для IPv6
            'visited_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
