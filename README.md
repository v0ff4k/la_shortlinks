# Laravel URL Shortener (Короткие ссылки)

Приложение на Laravel 10+, позволяющее пользователям создавать короткие ссылки, отслеживать переходы и управлять ими через панель администратора (Filament v3). Реализована аутентификация, создание URL, перенаправление с учётом посещений и статистика.

## Установка

1. Склонируйте репозиторий.
2. Скопируйте `.env.example` в `.env` и настройте подключение к базе данных.
3. Запустите миграции: `php artisan migrate`.
4. (Опционально) Загрузите начальные данные: `php artisan db:seed`.
5. Запустите сервер разработки: `php artisan serve`.
6. Откройте приложение по адресу `http://127.0.0.1:8000`.

## Возможности

- Регистрация и вход пользователей (Sanctum).
- Создание коротких URL с автоматической генерацией кода.
- Перенаправление с учётом посещений (IP-адрес, дата и время).
- Панель управления для просмотра, редактирования, удаления URL и аналитики.
- Встроенная страница статистики с количеством кликов и последними посещениями.

## Тестирование

Запустите тесты с помощью команды `php artisan test`.

## Развертывание

Для продакшена настройте обработчик очередей, установите supervisor и включите кэширование. Подробнее см. в официальной документации Laravel.

## Файловая структура (набросок)
  
    app/
    ├── Domains/
    │   ├── Url/
    │   │   ├── Models/
    │   │   │   └── Url.php
    │   │   ├── ValueObjects/
    │   │   │   ├── OriginalUrl.php
    │   │   │   └── ShortCode.php
    │   │   ├── Events/
    │   │   │   └── UrlVisited.php
    │   │   └── Exceptions/
    │   │       └── InvalidUrlException.php
    │   └── Analytics/
    │       ├── Models/
    │       │   └── UrlVisit.php
    │       └── ValueObjects/
    │           └── IpAddress.php
    ├── Application/
    │   ├── Url/
    │   │   ├── Commands/
    │   │   │   └── CreateShortUrlCommand.php
    │   │   ├── Handlers/
    │   │   │   └── CreateShortUrlHandler.php
    │   │   ├── Queries/
    │   │   │   └── GetUrlsQuery.php
    │   │   └── DTOs/
    │   │       └── CreateUrlDTO.php
    │   └── Analytics/
    │       ├── DTOs/
    │       │   └── TrackVisitDTO.php
    │       └── Handlers/
    │           └── TrackVisitHandler.php
    ├── Infrastructure/
    │   ├── Persistence/
    │   │   └── Repositories/
    │   │       └── UrlRepository.php
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   ├── UrlController.php
    │   │   │   └── RedirectController.php
    │   │   ├── Requests/
    │   │   │   └── CreateUrlRequest.php
    │   │   └── Resources/
    │   │       └── UrlResource.php
    │   └── Events/
    │       └── Listeners/
    │           └── LogVisitListener.php
    └── ...

---

### Дополнение

 - В папке database/ есть seeders.
Используйте команды `php artisan db:seed` или `php artisan migrate:fresh --seed` для их запуска.

 - Создать недостающие миддлвары:

    php artisan make:middleware TrustProxies
    php artisan make:middleware PreventRequestsDuringMaintenance
    php artisan make:middleware TrimStrings
    php artisan make:middleware EncryptCookies
    php artisan make:middleware VerifyCsrfToken
    php artisan make:middleware Authenticate
    php artisan make:middleware RedirectIfAuthenticated
    php artisan make:middleware ValidateSignature
    
Пример **TrustProxies.php**
```php
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    protected $proxies;

    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
```

 - Префиксы можно сгенерировать автоматически с помощью `php artisan make:migration`
 
 ---
 ## TODO 
 
 1. Добавить и прогнать статический анализ phpstan|psalm итп как дойдут руки.
 2. Обкатать docker-compose как будет много времени
 3. Поправить безопастность в mysql докера