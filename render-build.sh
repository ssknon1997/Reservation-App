#!/usr/bin/env bash
exit-on-error
composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
