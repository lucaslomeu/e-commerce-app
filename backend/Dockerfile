FROM php:8.3-fpm

# Instalar dependências
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo pdo_pgsql zip

# Instalar e habilitar redis
RUN pecl install redis && docker-php-ext-enable redis

# Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN docker-php-ext-install pcntl

RUN composer install

# Permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
