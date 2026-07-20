<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('urls', function (Blueprint $table): void {
            $table->unsignedBigInteger('visits_count')->default(0)->after('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('urls', function (Blueprint $table): void {
            $table->dropColumn('visits_count');
        });
    }
};
