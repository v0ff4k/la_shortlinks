<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use App\Domains\Url\Models\Url;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function test_url_reports_expiration_state(): void
    {
        Carbon::setTestNow('2026-07-08 12:00:00');

        $expired = new Url([
            'expires_at' => '2026-07-07 12:00:00',
        ]);

        $active = new Url([
            'expires_at' => '2026-07-09 12:00:00',
        ]);

        $this->assertTrue($expired->isExpired());
        $this->assertFalse($active->isExpired());

        Carbon::setTestNow();
    }
}
