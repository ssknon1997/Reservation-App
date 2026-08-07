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
    nginx

# PHP拡張機能のインストール
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composerの導入
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションファイルのコピー
WORKDIR /var/www/html
COPY . .

# Composerでのパッケージインストール
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install --no-dev --optimize-autoloader

# 権限の設定（エラーの原因だった部分を修正。一般的な www-data に変更）
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

COPY default.conf /etc/nginx/sites-available/default

# ポートの開放
EXPOSE 80

# 起動コマンド（NginxとPHP-FPMの両方を立ち上げる）
CMD service nginx start && php-fpm
