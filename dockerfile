FROM php:8.5-fpm

# 必要なパッケージとNginxのインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP拡張機能のインストール
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Composerの導入
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションファイルのコピー
WORKDIR /var/www/html
COPY . .

# Composerでのパッケージインストール
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# SQLiteデータベースファイルを作成
RUN touch database/database.sqlite

# Laravelのマイグレーションを実行
RUN php artisan migrate --force

# 権限の設定
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

COPY default.conf /etc/nginx/sites-available/default

# ポートの開放
EXPOSE 80

# 起動コマンド
CMD service nginx start && php artisan migrate --force && php-fpm
