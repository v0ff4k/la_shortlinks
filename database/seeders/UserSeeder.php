<?php

declare(strict_types=1);
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Domains\User\Models\User;
use Illuminate\Database\Seeder;

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
        User::firstOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin User',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        User::firstOrCreate(['email' => 'user@example.com'], [
            'name' => 'Test User',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);
    }
}
