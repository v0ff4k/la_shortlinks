<?php

declare(strict_types=1);

namespace Tests\Unit\Domains\Url\Events;

use App\Domains\Url\Events\UrlVisited;
use PHPUnit\Framework\TestCase;

class UrlVisitedTest extends TestCase
{
    public function test_event_stores_properties(): void
    {
        $event = new UrlVisited(urlId: 1, ip: '192.168.1.0');

        $this->assertSame(1, $event->urlId);
        $this->assertSame('192.168.1.0', $event->ip);
    }
}
