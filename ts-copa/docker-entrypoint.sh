#!/bin/sh
set -e

# .env must exist for artisan to work; env vars from Docker override it automatically
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

DB_PATH="${DB_DATABASE:-/var/www/html/database/database.sqlite}"

# Ensure database directory exists
mkdir -p "$(dirname "$DB_PATH")"
chown -R www-data:www-data "$(dirname "$DB_PATH")"

# Create SQLite file on first run
if [ ! -f "$DB_PATH" ]; then
    touch "$DB_PATH"
    chown www-data:www-data "$DB_PATH"
fi

# Generate app key only if not supplied via environment
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Seed only if admin user doesn't exist yet
ADMIN_EXISTS=$(php artisan tinker --execute="echo App\Models\User::where('name','admin')->count();" 2>/dev/null | tail -1 || echo "0")
if [ "$ADMIN_EXISTS" = "0" ]; then
    php artisan db:seed --force
fi

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec /usr/bin/supervisord -c /etc/supervisord.conf
