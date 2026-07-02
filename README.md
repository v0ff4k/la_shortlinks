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