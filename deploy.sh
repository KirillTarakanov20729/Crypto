#!/bin/bash

set -e

git pull origin main
php8.2 artisan down
php8.2 composer.phar install --no-dev --optimize-autoloader
php8.2 artisan migrate --force
php8.2 artisan config:cache
php8.2 artisan view:cache
php8.2 artisan up

