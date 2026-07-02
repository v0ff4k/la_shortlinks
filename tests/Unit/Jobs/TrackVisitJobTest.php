<?php

namespace Tests\Unit\Jobs;

use App\Domains\Analytics\Models\UrlVisit;
use App\Jobs\TrackVisitJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

// (Это уже ближе к Feature-тесту, но часто используется как "Integration Test", так как проверяет работу с БД.)
class TrackVisitJobTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Queue::fake();
    }

    public function test_job_creates_visit_record_in_database(): void
    {
        $job = new TrackVisitJob(urlId: 1, ip: '192.168.1.0');
        $job->handle();

        $this->assertDatabaseHas('url_visits', [
            'url_id' => 1,
            'ip_address' => '192.168.1.0',
        ]);
    }
}