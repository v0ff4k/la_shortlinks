<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Domains\Url\Models\Url;
use App\Infrastructure\Jobs\TrackVisitJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domains\User\Models\User;
use Tests\TestCase;

class TrackVisitJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_creates_visit_record_in_database(): void
    {
        $user = User::factory()->create();
        $url = Url::factory()->create([
            'user_id' => $user->id,
        ]);

        $job = new TrackVisitJob(urlId: $url->id, ip: '192.168.1.42');
        $job->handle();

        $this->assertDatabaseHas('url_visits', [
            'url_id' => $url->id,
            'ip_address' => '192.168.1.0',
        ]);
    }
}
