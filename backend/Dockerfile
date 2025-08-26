FROM php:8.2-fpm

# 安裝系統依賴、cron、Python 與 venv
RUN apt-get update && apt-get install -y \
        git zip unzip libpq-dev libonig-dev cron \
        python3 python3-venv python3-pip build-essential libffi-dev libssl-dev dos2unix \
    && docker-php-ext-install pdo pdo_pgsql

# 建立 Python venv，安裝爬蟲套件
RUN python3 -m venv /opt/venv
ENV PATH="/opt/venv/bin:$PATH"

RUN pip install --upgrade pip setuptools wheel
RUN pip install beautifulsoup4 psycopg2-binary feedparser requests

# 安裝 Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-interaction --optimize-autoloader

# 設定 cron file 權限（不要在 build 時 crontab）
COPY laravel-cron /etc/cron.d/laravel-cron
RUN dos2unix /etc/cron.d/laravel-cron \
    && chmod 0644 /etc/cron.d/laravel-cron

# 建立 cron log
RUN touch /var/log/cron.log

EXPOSE 9000

# 啟動 cron 與 php-fpm
CMD ["sh", "-c", "cron && tail -f /var/log/cron.log & php-fpm"]
