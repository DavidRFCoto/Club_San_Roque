#!/bin/bash

echo "=== Iniciando despliegue ==="

if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY no esta configurada!"
    exit 1
fi

echo "APP_KEY detectada: ${APP_KEY:0:20}..."
echo "DB_HOST: ${DB_HOST}"
echo "DB_USERNAME: [${DB_USERNAME}]"
echo "DB_PASSWORD length: ${#DB_PASSWORD}"
echo "DB_PORT: ${DB_PORT:-5432}"
echo "DB_DATABASE: ${DB_DATABASE}"

cat > /var/www/html/.env << 'ENVEOF'
APP_ENV=production
APP_DEBUG=false
ENVEOF

echo "APP_KEY=${APP_KEY}" >> /var/www/html/.env
echo "APP_URL=${APP_URL:-http://localhost}" >> /var/www/html/.env
echo "DB_CONNECTION=${DB_CONNECTION:-pgsql}" >> /var/www/html/.env
echo "DB_HOST=${DB_HOST}" >> /var/www/html/.env
echo "DB_PORT=${DB_PORT:-5432}" >> /var/www/html/.env
echo "DB_DATABASE=${DB_DATABASE:-postgres}" >> /var/www/html/.env
echo "DB_USERNAME=${DB_USERNAME}" >> /var/www/html/.env
printf 'DB_PASSWORD=%s\n' "$DB_PASSWORD" >> /var/www/html/.env
echo "SUPABASE_URL=${SUPABASE_URL}" >> /var/www/html/.env
echo "SUPABASE_ANON_KEY=${SUPABASE_ANON_KEY}" >> /var/www/html/.env
echo "SUPABASE_SERVICE_KEY=${SUPABASE_SERVICE_KEY}" >> /var/www/html/.env
echo "SESSION_DRIVER=${SESSION_DRIVER:-cookie}" >> /var/www/html/.env
echo "CACHE_DRIVER=${CACHE_DRIVER:-file}" >> /var/www/html/.env
echo "LOG_CHANNEL=${LOG_CHANNEL:-stderr}" >> /var/www/html/.env
echo "LOG_LEVEL=${LOG_LEVEL:-error}" >> /var/www/html/.env

echo ".env generado:"
grep -v 'PASSWORD\|KEY' /var/www/html/.env
echo "---"

echo "Ejecutando migraciones..."
php artisan migrate --force --no-interaction 2>&1 || echo "Warning: Migraciones fallaron, continuando..."

echo "Limpiando cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "=== Aplicacion lista ==="

exec "$@"
