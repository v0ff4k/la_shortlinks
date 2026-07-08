<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_is_rendered_with_project_landing(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Shorten URLs and inspect every click from one panel.');
        $response->assertSee('admin@example.com');
        $response->assertSee('/admin/login');
    }
}
