<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('url_visits', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('url_id')->constrained();
            $table->ipAddress('ip_address');
            $table->timestamp('visited_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('url_visits');
    }
};
