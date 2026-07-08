<?php

declare(strict_types=1);

// fruitcake/laravel-cors, который управляет заголовками Cross-Origin Resource Sharing (CORS).
// Файл config/cors.php нужен только если используется пакет fruitcake/laravel-cors.
return [
    'supports_credentials' => true,
    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
];
