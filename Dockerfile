FROM php:8.4

WORKDIR /app

RUN apt-get update && apt-get install -y git curl zip unzip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .


RUN composer install --no-interaction --prefer-dist


RUN mkdir -p storage/framework/views \
    storage/framework/cache \
    storage/framework/sessions \
    bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache storage/framework


RUN php artisan config:clear || true \
    && php artisan cache:clear || true \
    && php artisan view:clear || true

RUN touch database/database.sqlite

RUN mkdir -p storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN cp .env.example .env \
    && php artisan key:generate && php artisan migrate

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]