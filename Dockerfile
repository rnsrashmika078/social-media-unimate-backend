FROM php:8.4

WORKDIR /app

# test

# CHANGE 1: Added 'docker-php-ext-install pdo pdo_mysql' at the end of this run command
RUN apt-get update && apt-get install -y git curl zip unzip \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --prefer-dist
RUN cp .env.example .env && php artisan key:generate

# Removed the SQLite database line entirely since you are using Azure MySQL

RUN mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache && \
    chmod -R 777 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]