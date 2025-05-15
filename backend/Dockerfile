FROM php:8.3-fpm

# Instalar dependências
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Instale dependências do Laravel
COPY . /var/www

RUN composer install

# Permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
