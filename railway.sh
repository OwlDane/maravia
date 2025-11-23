#!/bin/bash

# Exit on error
set -e

echo "Running migrations..."
php artisan migrate --force

echo "Starting web server..."
php -d variables_order=EGPCS -S 0.0.0.0:$PORT -t public server.php
