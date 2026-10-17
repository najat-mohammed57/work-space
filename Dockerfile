FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate --show > /tmp/key || true

EXPOSE 10000

CMD php artisan serve --host 0.0.0.0 --port 10000
