FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    nano

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip xml curl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www


COPY . /var/www

# Copia i file entrypoint esplicitamente da cartella dedicata
COPY ./entrypoint_1.sh /usr/local/bin/entrypoint_1.sh
COPY ./entrypoint_2.sh /usr/local/bin/entrypoint_2.sh

RUN chmod +x /usr/local/bin/entrypoint_1.sh /usr/local/bin/entrypoint_2.sh


# Permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www
