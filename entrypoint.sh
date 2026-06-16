#!/bin/bash
set -e

echo "=== Iniciando despliegue ==="

cat > /var/www/html/.env << EOF
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
EOF

echo ".env generado"

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
