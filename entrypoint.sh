#!/bin/sh

# Wait for DB to be ready
echo "Waiting for database..."
until pg_isready -h db -U laravel > /dev/null 2>&1; do
  sleep 1
done
echo "Database is ready."

# Migrate and seed
php artisan migrate --force
php artisan db:seed --force

# Install Passport keys
php artisan passport:install --force

# Optional: extract keys and inject into .env
PUBLIC_KEY=$(cat storage/oauth-public.key | base64 | tr -d '\n')
PRIVATE_KEY=$(cat storage/oauth-private.key | base64 | tr -d '\n')

echo "OAUTH_PUBLIC_KEY=\"$PUBLIC_KEY\"" >> .env
echo "OAUTH_PRIVATE_KEY=\"$PRIVATE_KEY\"" >> .env

# Serve the app
php artisan serve --host=0.0.0.0 --port=8000
