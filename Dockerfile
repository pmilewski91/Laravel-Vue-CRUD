FROM php:8.3-apache

# Włącz mod_rewrite dla Laravel
RUN a2enmod rewrite

# Instalacja wymaganych rozszerzeń PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd

# Instalacja Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ustawienie DocumentRoot na public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Kopiowanie konfiguracji Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Kopiowanie plików aplikacji
COPY . /var/www/html

# Ustawienie uprawnień
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

WORKDIR /var/www/html

# Instalacja zależności
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Tworzenie bazy SQLite
RUN touch /var/www/html/database/database.sqlite \
    && chown www-data:www-data /var/www/html/database/database.sqlite

# Kopiowanie i ustawienie skryptu startowego
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

CMD ["docker-entrypoint.sh"]
