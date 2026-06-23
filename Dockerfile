FROM php:8.4

WORKDIR /app

# test


RUN apt-get update && apt-get install -y git curl zip unzip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --prefer-dist
RUN cp .env.example .env \
    && php artisan key:generate \
    && mkdir -p database \
    && touch database/database.sqlite

RUN chmod -R 777 storage bootstrap/cache \
    && mkdir -p database \
    && touch database/database.sqlite \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && chmod -R 777 storage bootstrap/cache 


RUN mkdir -p storage bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]