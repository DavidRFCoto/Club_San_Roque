#!/bin/bash

echo "=== Iniciando despliegue ==="

if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY no esta configurada!"
    exit 1
fi

echo "APP_KEY detectada: ${APP_KEY:0:20}..."
echo "DB_HOST: ${DB_HOST}"
echo "DB_USERNAME: [${DB_USERNAME}]"
echo "DB_PASSWORD: [${DB_PASSWORD:0:5}...]"
echo "DB_PORT: ${DB_PORT:-5432}"
echo "DB_DATABASE: ${DB_DATABASE}"

cat > /var/www/html/.env << ENVEOF
APP_ENV=${APP_ENV:-production}
APP_DEBUG=${APP_DEBUG:-false}
APP_KEY=${APP_KEY}
APP_URL=${APP_URL:-http://localhost}
DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE:-postgres}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
SUPABASE_URL=${SUPABASE_URL}
SUPABASE_ANON_KEY=${SUPABASE_ANON_KEY}
SUPABASE_SERVICE_KEY=${SUPABASE_SERVICE_KEY}
SESSION_DRIVER=${SESSION_DRIVER:-cookie}
CACHE_DRIVER=${CACHE_DRIVER:-file}
LOG_CHANNEL=${LOG_CHANNEL:-stderr}
LOG_LEVEL=${LOG_LEVEL:-error}
ENVEOF

echo ".env generado:"
cat /var/www/html/.env
echo "---"

echo "Ejecutando migraciones..."
php artisan migrate --force --no-interaction 2>&1 || echo "Warning: Migraciones fallaron, continuando..."

echo "Limpiando cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "=== Aplicacion lista ==="

exec "$@"
