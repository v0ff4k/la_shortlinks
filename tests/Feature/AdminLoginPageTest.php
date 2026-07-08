<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class AdminLoginPageTest extends TestCase
{
    public function test_admin_login_page_is_available(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk();
    }
}
