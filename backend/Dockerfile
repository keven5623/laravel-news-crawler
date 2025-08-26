FROM php:8.2-fpm

# Install dependencies + cron
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev libonig-dev cron \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel project
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Add crontab file
COPY laravel-cron /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron
RUN crontab /etc/cron.d/laravel-cron

# Expose port
EXPOSE 9000

# Start cron + php-fpm
CMD ["sh", "-c", "cron && php-fpm"]
