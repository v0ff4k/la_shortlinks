FROM php:8.2-fpm-alpine

# Установка системных зависимостей, включая ICU для расширения 'intl'
RUN apk add --no-cache \
    bash \
    curl \
    git \
    libzip-dev \
    zip \
    unzip \
    icu-dev # <-- Добавлено: ICU библиотеки

# Компиляция и установка PHP-расширений
RUN docker-php-ext-install \
    intl \
    pdo_mysql \
    zip

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Установка зависимостей PHP
# Используем --ignore-platform-reqs как временное решение для уязвимостей
# ВНИМАНИЕ: Это снижает безопасность. В продакшене лучше обновить пакеты.
RUN composer install --ignore-platform-reqs --no-dev --optimize-autoloader

CMD ["php-fpm"]