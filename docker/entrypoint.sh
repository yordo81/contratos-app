#!/bin/bash
set -e

echo "🔄 Waiting for MySQL..."

# Wait for MySQL to be ready
until php artisan db:monitor --once 2>/dev/null; do
    echo "⏳ MySQL not ready yet, waiting..."
    sleep 2
done

echo "✅ MySQL is ready!"

# Generate app key if not set
if [ -z "$(grep -o 'APP_KEY=base64:[^ ]*' .env 2>/dev/null | cut -d: -f2)" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# Run seeder if tables are empty
if [ "$(php artisan tinker --execute='echo \App\Models\Contrato::count();' 2>/dev/null)" = "0" ]; then
    echo "🌱 Seeding database..."
    php artisan db:seed --force
fi

# Cache config for production
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Caching configuration..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

echo "🚀 Application is ready!"

exec "$@"
