#!/bin/bash
set -e

echo "=== Iniciando despliegue ==="

if [ "$DB_CONNECTION" = "pgsql" ] && [ -n "$DB_HOST" ]; then
    echo "Ejecutando migraciones..."
    php artisan migrate --force --no-interaction || echo "Warning: Migraciones fallaron, continuando..."
fi

echo "Limpiando cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "=== Aplicacion lista ==="

exec "$@"
