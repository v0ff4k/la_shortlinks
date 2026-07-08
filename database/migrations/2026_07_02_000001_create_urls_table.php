<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('urls', function (Blueprint $table): void {
            $table->id();
            // Явно указываем nullable И constrained отдельно, чтобы избежать проблем с порядком
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('original_url');
            $table->string('short_code')->unique();
            $table->timestamps();

            // Внешний ключ добавляем ПОСЛЕ создания всех колонок
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
