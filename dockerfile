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

# Node.jsのインストール
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# PHP拡張機能
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーション
WORKDIR /var/www/html
COPY . .

# Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader

# Nodeパッケージ
RUN npm install

# Viteのビルド
RUN npm run build

# SQLite
RUN touch database/database.sqlite

# 権限
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

COPY default.conf /etc/nginx/sites-available/default

EXPOSE 80

# 起動
CMD service nginx start && php artisan migrate --seed --force && php-fpm
