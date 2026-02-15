#!/bin/sh
set -e

echo "🚀 Starting deployment..."

# Ensure storage directories exist
mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Ensure SQLite database exists
if [ ! -f database/database.sqlite ]; then
    echo "📦 Creating SQLite database..."
    touch database/database.sqlite
    chown www-data:www-data database/database.sqlite
fi

# Run migrations
echo "🔄 Running migrations..."
php artisan migrate --force

# Cache for production
echo "⚡ Caching config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link
echo "🔗 Creating storage link..."
php artisan storage:link 2>/dev/null || true

echo "✅ Ready! Starting services..."

# Start supervisor (manages php-fpm + nginx)
exec /usr/bin/supervisord -c /etc/supervisord.conf
