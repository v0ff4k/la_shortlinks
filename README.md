# Laravel URL Shortener

Приложение на Laravel 12 и Filament 5 для создания коротких ссылок, отслеживания переходов и управления ими через админ-панель.

    ✅ Строгая типизация на максимальном уровне
    ✅ Единый стиль кода без конфликтов между инструментами
    ✅ Чистая DDD-архитектура с изолированными доменами
    ✅ Работающий сервис с аналитикой и защитой от циклов

## Что умеет

- Создавать короткие ссылки с авто-генерацией кода или custom alias.
- РедиректитЪ по короткой ссылке на оригинальный URL.
- Сохранять статистику переходов с IP и временем визита.
- Управлять ссылками через Filament admin.

## Быстрый старт

1. Поднимите окружение.
2. Примените миграции и seed.
3. Откройте `http://127.0.0.1:28000/admin/login`.

### Docker bootstrap

Самый быстрый путь для чистого разворота:

```bash
sh docker/bootstrap.sh
```

Можно также использовать Composer-алиас:

```bash
composer bootstrap:docker
```

Скрипт:

- поднимает контейнеры;
- выполняет `php artisan migrate:fresh --seed --force`;
- очищает кэш Laravel после миграций.

## Тестовые аккаунты

Дополнительно импорт пользователей в `database/seeders/UserSeeder.php`
После `migrate:fresh --seed` доступны пользователи:

- `admin@example.com` / `password`
- `user@example.com` / `password`
- `user@serv.com` / `user@serv.com`
Они-же есть при развороте проекта.


## Команды Laravel

- `php artisan migrate`
- `php artisan db:seed`
- `php artisan migrate:fresh --seed`
- `php artisan route:list`
- `php artisan route:list --path=admin`
- `php artisan config:clear`
- `php artisan route:clear`
- `php artisan cache:clear`
- `php artisan key:generate --ansi`
- `php artisan package:discover --ansi`
- `composer test`


Для изменения в филаменте, команды:
- `php artisan filament:clear-cached-components`
- `php artisan optimize:clear`


Чистка всего кеша:
- `php artisan optimize:clear`
- `php artisan filament:clear-cached-components`
- `php artisan route:clear`
- `php artisan config:clear`
- `php artisan view:clear`

## Качество кода

- `composer analyse`
- `composer format`
- `composer format:test`

`App\Filament` должен лежать в `App\Infrastructure\Filament по канонам` **DDD**
├── Infrastructure/
│   └── Admin/             # Вместо app/Filament
│       ├── Resources/
│       ├── Pages/
│       └── Widgets/
└── Providers/Filament/    # Остается здесь

## Тестирование

Feature-тесты покрывают главную страницу и страницу входа в админку.
Unit-тесты покрывают DTO, command, handler, job и доменную логику модели `Url`.
