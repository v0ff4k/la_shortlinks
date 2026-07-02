<?php

namespace Tests\Feature;

use App\Domains\Url\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_short_url(): void
    {
        $user = \App\Models\User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson('/api/urls', [
            'original_url' => 'https://example.com',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('urls', [
            'original_url' => 'https://example.com',
        ]);
    }
}
