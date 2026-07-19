#!/bin/bash
set -e

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

if ! grep -q "^APP_KEY=base64" .env; then
    php artisan key:generate --force --ansi
fi

echo "Waiting for MySQL at ${DB_HOST:-mysql}:${DB_PORT:-3306}..."
until php -r "new PDO('mysql:host=${DB_HOST:-mysql};port=${DB_PORT:-3306}', '${DB_USERNAME:-idc}', '${DB_PASSWORD:-secret}');" > /dev/null 2>&1; do
    sleep 1
done
echo "MySQL is up."

php artisan migrate --force

if [ ! -L public/storage ]; then
    php artisan storage:link
fi

exec "$@"
