#!/bin/bash

set -e

echo "======================================"
echo "Starting Laravel container..."
echo "======================================"

echo "Running Laravel migrations..."

php artisan migrate --force -vvv

echo "Migration command finished."

echo "Starting Apache..."

echo "=== APACHE DOCUMENT ROOT ==="
grep -R "DocumentRoot" /etc/apache2/sites-enabled /etc/apache2/sites-available

echo "=== APACHE MODULES ==="
apache2ctl -M | grep -E 'headers|rewrite'

echo "=== APACHE VHOST ==="
apache2ctl -S

echo "=== APACHE CONFIG ==="
apache2ctl -t -D DUMP_RUN_CFG

exec apache2-foreground