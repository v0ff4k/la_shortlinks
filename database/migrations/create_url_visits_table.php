<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('url_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('url_id')->constrained();
            $table->ipAddress('ip_address'); // Laravel 10+
            $table->timestamp('visited_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('url_visits');
    }
};