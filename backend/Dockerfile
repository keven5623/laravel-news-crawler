FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel project
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# php-fpm 預設就是跑在 9000
EXPOSE 9000

CMD ["php-fpm"]
