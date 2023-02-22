#!/bin/bash

# eerst keer: chmod 770 clear.sh 

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
