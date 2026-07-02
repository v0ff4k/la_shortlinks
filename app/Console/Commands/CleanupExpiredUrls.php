<?php

namespace App\Console\Commands;

use App\Domains\Url\Models\Url;
use Illuminate\Console\Command;

class CleanupExpiredUrls extends Command
{
    protected $signature = 'url:cleanup';
    protected $description = 'Delete expired URLs';

    public function handle(): void
    {
        $count = Url::whereNotNull('expires_at')->where('expires_at', '<', now())->delete();
        $this->info("Deleted {$count} expired URLs.");
    }
}
