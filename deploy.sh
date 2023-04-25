#!/bin/bash

# eerst keer: chmod 770 deploy.sh 

php artisan down --refresh=15

git pull

# php composer.phar install --no-interaction --prefer-dist --optimize-autoloader --no-dev
# composer install

php artisan migrate

# Clear caches
php artisan cache:clear

# clear config
php artisan config:clear

# Clear expired password reset tokens
php artisan auth:clear-resets

# Clear and cache routes
php artisan route:cache

# Clear and cache config
php artisan config:cache

# Clear and cache views
php artisan view:cache

# Install node modules
npm ci

# Build assets using Vite
npm run build

# link the public files
php artisan storage:link 

# Turn off maintenance mode
php artisan up

