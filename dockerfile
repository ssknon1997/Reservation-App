FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev

COPY ./nginx.conf /etc/nginx/sites-available/default

RUN chown -R xfs:xfs /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD service nginx start && php-fpm
