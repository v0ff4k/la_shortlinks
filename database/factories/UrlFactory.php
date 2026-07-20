<?php

declare(strict_types=1);
// database/factories/UrlFactory.php

namespace Database\Factories;

use App\Domains\Url\Models\Url;
use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для создания тестовых URL в домене Url.
 * @extends Factory<Url>
 */
class UrlFactory extends Factory
{
    protected $model = Url::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Создаст случайного пользователя, если не указан
            'original_url' => fake()->url(),
            'short_code' => fake()->unique()->lexify('??????'), // Случайный 6-символьный код
            // 'custom_alias' => null, // Может быть null
            // 'expires_at' => null,   // Может быть null
        ];
    }

    /**
     * Indicate that the URL has a custom alias.
     */
    public function withCustomAlias(): static
    {
        return $this->state(fn(array $attributes) => [
            'custom_alias' => fake()->unique()->lexify('???-???'),
            'short_code' => fake()->unique()->lexify('???-???'), //  short_code uniq, if alias created
        ]);
    }

    /**
     * Indicate that the URL has an expiration date.
     */
    public function withExpiration(): static
    {
        return $this->state(fn(array $attributes) => [
            'expires_at' => fake()->dateTimeBetween('+1 month', '+1 year'),
        ]);
    }
}
