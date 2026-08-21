#!/bin/bash

echo "======================================"
echo "Starting Laravel container..."
echo "======================================"

echo "Running Laravel migrations..."

php artisan migrate --force -vvv

echo "Migration command finished with code: $?"

echo "Starting Apache..."

exec apache2-foreground