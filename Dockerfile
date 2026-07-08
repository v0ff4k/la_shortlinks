FROM php:8.2-fpm-alpine

## Install shadow package to get 'usermod' and 'groupmod'
RUN apk add --no-cache shadow && \
    # Reassign or delete existing user/group using ID 33 (often 'xfs')
    if getent passwd 33; then deluser $(getent passwd 33 | cut -d: -f1); fi && \
    if getent group 33; then delgroup $(getent group 33 | cut -d: -f1); fi && \
    # Modify www-data to use 33:33
    usermod -u 33 www-data && \
    groupmod -g 33 www-data
# orig ID:82 (www-data)

# Установка системных зависимостей и PHP-расширений в одном блоке
RUN apk add --no-cache \
        bash curl git zip unzip \
        libzip-dev icu-dev \
        freetype-dev libjpeg-turbo-dev libpng-dev libwebp-dev \
        oniguruma-dev \
        # Для сборки PECL расширений нужны autoconf, dpkg-dev, file, g++, gcc, libc-dev, make, pkgconf
        $PHPIZE_DEPS && \
    # Устанавливаем Redis через PECL (без redis-dev)
    pecl install redis && \
    docker-php-ext-enable redis && \
    # Конфигурируем и устанавливаем встроенные расширения
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc) \
        intl \
        pdo_mysql \
        zip \
        gd \
        mbstring \
        opcache && \
    # Очищаем кэш apk и временные файлы сборки
    apk del $PHPIZE_DEPS && \
    rm -rf /tmp/pear

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем composer файлы и устанавливаем зависимости
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Копируем остальные файлы
COPY . .

# Права на директории
# RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Создаём директории для supervisord с правами для www-data (если нужно логировать в файлы внутри контейнера)
# RUN mkdir -p /var/log/supervisor && chown -R www-data:www-data /var/log/supervisor /tmp

# Копируем конфиг supervisord
#COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Указываем, что команда CMD/ENTRYPOINT будет выполняться от имени пользователя www-data
USER www-data

EXPOSE 9000

#CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

CMD ["php-fpm"]