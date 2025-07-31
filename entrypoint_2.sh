#!/bin/sh

echo "➤ Attendo che app_a sia pronta..."

echo "📄 Inizializzazione .env da .env.example..."
cp /var/www/.env.example /var/www/.env
# Attendi che app_a risponda sull'API
until curl -s http://app_a:8000/api/auth/client-credentials | grep -q 'client_id'; do
  echo "⏳ app_a non è ancora pronta, ritento tra 2s..."
  sleep 2
done

echo "➤ Recupero credenziali da app_a..."

response=$(curl -s http://app_a:8000/api/auth/client-credentials)

echo "RESPONSE=$response"

client_id=$(echo "$response" | grep -oP '"client_id"\s*:\s*"\K[^"]+')
client_secret=$(echo "$response" | grep -oP '"client_secret"\s*:\s*"\K[^"]+')

if [ -n "$client_id" ] && [ -n "$client_secret" ]; then
  echo "PASSWORD_CLIENT_ID=$client_id" >> /var/www/.env
  echo "PASSWORD_CLIENT_SECRET=$client_secret" >> /var/www/.env
  echo "✅ Credenziali salvate in .env di app_b"
else
  echo "❌ Errore nel recupero delle credenziali"
  exit 1
fi

echo "🚀 Avvio Laravel su app_b..."
php artisan serve --host=0.0.0.0 --port=8001
