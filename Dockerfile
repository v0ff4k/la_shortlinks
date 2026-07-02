FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    bash \
    curl \
    git \
    libzip-dev \
    zip \
    unzip \
    icu-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    oniguruma-dev \
    redis \
    supervisor

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    gd \
    mbstring

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Установка зависимостей PHP (без --ignore-platform-reqs)
# This flag bypasses all platform requirement checks. The comment even acknowledges it "reduces security."
# This must never be in a production image
RUN composer install --no-dev --optimize-autoloader

# Настройка supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Создание непривилегированного пользователя
RUN addgroup -g 1000 -S www-data && \
    adduser -u 1000 -S www-data -G www-data

# Установка прав на директорию
RUN chown -R www-data:www-data /var/www

USER www-data

EXPOSE 9000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]