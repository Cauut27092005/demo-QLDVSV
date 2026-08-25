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

echo "=== APACHE MODULES ==="
apache2ctl -M | grep -E 'headers|rewrite|proxy'

echo "=== APACHE CONFIG ==="
apache2ctl -S

echo "Starting Apache..."

echo "=== APACHE DOCUMENT ROOT ==="
grep -R "DocumentRoot" /etc/apache2/sites-enabled /etc/apache2/sites-available

echo "=== APACHE HEADERS MODULE ==="
apache2ctl -M | grep headers

echo "=== APACHE MODULES ==="
apache2ctl -M | sort

echo "=== APACHE VHOST ==="
apache2ctl -S

echo "=== APACHE CONFIG ==="
apache2ctl -t -D DUMP_RUN_CFG

exec apache2-foreground