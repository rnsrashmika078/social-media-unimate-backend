FROM php:8.4

WORKDIR /app

RUN apt-get update && apt-get install -y git curl zip unzip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --prefer-dist

RUN cp .env.example .env \
    && php artisan key:generate && php artisan migrate

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]