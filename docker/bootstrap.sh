#!/usr/bin/env sh
set -eu

if docker compose version >/dev/null 2>&1; then
    DOCKER="docker compose"
else
    DOCKER="docker-compose"
fi

echo "Starting containers..."
$DOCKER up -d --build

echo "Running migrations and seeders..."
$DOCKER exec -T app sh -lc 'php artisan migrate:fresh --seed --force && php artisan optimize:clear'
