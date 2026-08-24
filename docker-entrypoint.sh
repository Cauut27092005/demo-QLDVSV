#!/bin/bash

echo "======================================"
echo "Starting Laravel container..."
echo "======================================"

echo "Clearing Laravel cached configuration..."
php artisan optimize:clear

echo "Caching Laravel configuration..."
php artisan config:cache

echo "Running Laravel migrations..."
php artisan migrate --force -vvv

echo "Migration command finished with code: $?"

echo "Starting Apache..."
exec apache2-foreground