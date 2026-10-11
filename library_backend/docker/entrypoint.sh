#!/bin/sh
set -e

# Ensure .env exists
if [ ! -f /var/www/.env ]; then
    echo "Creating .env from .env.example..."
    cp /var/www/.env.example /var/www/.env
fi

# Ensure dependencies are installed if vendor is empty/missing
if [ ! -f /var/www/vendor/autoload.php ]; then
    echo "Installing composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Ensure APP_KEY exists
if ! grep -q "APP_KEY=base64:" /var/www/.env 2>/dev/null; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Wait for PostgreSQL
if [ -n "$DB_HOST" ]; then
    echo "Waiting for PostgreSQL at $DB_HOST:${DB_PORT:-5432}..."
    until pg_isready -h "$DB_HOST" -p "${DB_PORT:-5432}" -U "${DB_USERNAME:-library_user}" > /dev/null 2>&1; do
        sleep 1
    done
    echo "PostgreSQL is ready!"
fi

# Ensure writable permissions for cache and storage
chmod -R 777 /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true

exec "$@"
