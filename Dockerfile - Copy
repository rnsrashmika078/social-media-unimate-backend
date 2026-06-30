FROM php:8.4-apache

# 1. Install system dependencies and enable Apache rewrite mode for Laravel routing
RUN apt-get update && apt-get install -y git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && a2enmod rewrite \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/0000-default.conf

WORKDIR /var/www/html

# 2. Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Copy application files
COPY . .

# 4. Install production dependencies
RUN composer install --no-interaction --prefer-dist --no-dev

# 5. Set up SQLite and directories
RUN mkdir -p database && touch database/database.sqlite
RUN mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data /var/www/html

# Apache automatically exposes port 80 and runs in the foreground, 
# so you don't even need a custom CMD line!