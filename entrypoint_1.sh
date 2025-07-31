#!/bin/sh

# Wait for DB to be ready
#echo "Waiting for database..."
#until pg_isready -h db -U laravel > /dev/null 2>&1; do
#  sleep 1
#done
#echo "Database is ready."
ls -al

echo "📄 Inizializzazione .env da .env.example..."
cp /var/www/.env.example /var/www/.env
# Migrate and seed
php artisan migrate --force
php artisan db:seed --force

#!/bin/sh

echo "Generating passport client..."
output=$(php artisan passport:client --password --name="Password Grant" --no-interaction)

# Estraggo client_id e client_secret
client_id=$(echo "$output" | awk -F'\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\. ' '/Client ID/ {print $2}')
client_secret=$(echo "$output" | awk -F'\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\.\\. ' '/Client Secret/ {print $2}')

# Stampo per conferma
echo "Client ID: $client_id"
echo "Client Secret: $client_secret"


# Se sono validi, li salvo nel file .env condiviso
if [ -n "$client_id" ] && [ -n "$client_secret" ]; then
  echo "PASSWORD_CLIENT_ID=$client_id" >> /var/www/.env
  echo "PASSWORD_CLIENT_SECRET=$client_secret" >> /var/www/.env
  echo "✅ Credentials salvate nel .env dell'app"
fi


echo "Fixing key permissions..."
chmod 600 /var/www/storage/oauth-private.key
chmod 600 /var/www/storage/oauth-public.key


# Avvio server Laravel (modifica in base al tuo comando reale)
php artisan serve --host=0.0.0.0 --port=8000
