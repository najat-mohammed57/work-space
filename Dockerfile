FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libonig-dev libpng-dev libicu-dev libsqlite3-dev curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN a2enmod rewrite
WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN npm install --legacy-peer-deps || true
RUN npm run build || true

RUN mkdir -p database && touch database/database.sqlite
RUN chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80
CMD sh -c "php artisan migrate --force --seed && php artisan storage:link || true && php artisan serve --host=0.0.0.0 --port=$PORT"
