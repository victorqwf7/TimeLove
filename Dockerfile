FROM php:8.2-fpm

# Instale dependências
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    && docker-php-ext-install pdo_pgsql

# Configure o ambiente
WORKDIR /var/www/html
COPY . .

# Instale o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure permissões e dependências do Laravel
RUN composer install --optimize-autoloader --no-dev \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html