#!/bin/bash
set -e

echo "=== Iniciando despliegue ==="

if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY no esta configurada!"
    exit 1
fi

echo "APP_KEY detectada: ${APP_KEY:0:20}..."
echo "SUPABASE_URL: ${SUPABASE_URL}"
echo "SUPABASE_ANON_KEY: ${SUPABASE_ANON_KEY:0:15}..."
echo "DB_HOST: ${DB_HOST}"
echo "DB_USERNAME: ${DB_USERNAME}"
echo "DB_PORT: ${DB_PORT:-5432}"

cat > /etc/apache2/conf-available/laravel-env.conf << EOF
SetEnv APP_ENV "${APP_ENV:-production}"
SetEnv APP_DEBUG "${APP_DEBUG:-false}"
SetEnv APP_KEY "${APP_KEY}"
SetEnv APP_URL "${APP_URL:-http://localhost}"
SetEnv DB_CONNECTION "${DB_CONNECTION:-pgsql}"
SetEnv DB_HOST "${DB_HOST}"
SetEnv DB_PORT "${DB_PORT:-5432}"
SetEnv DB_DATABASE "${DB_DATABASE:-postgres}"
SetEnv DB_USERNAME "${DB_USERNAME}"
SetEnv DB_PASSWORD "${DB_PASSWORD}"
SetEnv SUPABASE_URL "${SUPABASE_URL}"
SetEnv SUPABASE_ANON_KEY "${SUPABASE_ANON_KEY}"
SetEnv SUPABASE_SERVICE_KEY "${SUPABASE_SERVICE_KEY}"
SetEnv SESSION_DRIVER "${SESSION_DRIVER:-cookie}"
SetEnv CACHE_DRIVER "${CACHE_DRIVER:-file}"
SetEnv LOG_CHANNEL "${LOG_CHANNEL:-stderr}"
SetEnv LOG_LEVEL "${LOG_LEVEL:-error}"
EOF

a2enconf laravel-env

echo "Variables configuradas en Apache"

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
