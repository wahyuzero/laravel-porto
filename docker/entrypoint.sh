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

# Create admin user from env vars (if set)
if [ -n "$ADMIN_EMAIL" ] && [ -n "$ADMIN_PASSWORD" ]; then
    echo "👤 Creating/updating admin user..."
    php artisan admin:create --email="$ADMIN_EMAIL" --password="$ADMIN_PASSWORD" --name="${ADMIN_NAME:-Admin}"
fi

# Run demo seeder on first deploy (if no users exist)
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tr -d '[:space:]')
if [ "$USER_COUNT" = "0" ] || [ "$USER_COUNT" = "" ]; then
    echo "🌱 First deploy detected — seeding demo data..."
    php artisan db:seed --class=DemoSeeder --force 2>/dev/null || true
fi

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
