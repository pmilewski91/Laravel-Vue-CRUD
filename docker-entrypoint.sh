#!/bin/bash

# Skopiuj .env.example do .env jeśli .env nie istnieje
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
    chown www-data:www-data /var/www/html/.env
fi

# Wygeneruj klucz aplikacji jeśli nie istnieje
if ! grep -q "APP_KEY=base64:" /var/www/html/.env; then
    php artisan key:generate --force
fi

# Upewnij się, że katalog database ma odpowiednie uprawnienia
chown -R www-data:www-data /var/www/html/database
chmod -R 755 /var/www/html/database

# Upewnij się, że baza danych istnieje i ma odpowiednie uprawnienia
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
fi
chown www-data:www-data /var/www/html/database/database.sqlite
chmod 664 /var/www/html/database/database.sqlite

# Wykonaj migracje
php artisan migrate --force

# Opcjonalnie: załaduj dane testowe
# php artisan db:seed --force

# Uruchom Apache
apache2-foreground
