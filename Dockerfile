# Use PHP-FPM como base
FROM php:8.2-fpm

# Instale dependências do sistema e do PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    nginx \
    && docker-php-ext-install pdo_pgsql

# Configure o ambiente de trabalho
WORKDIR /var/www/html

# Copie o código do Laravel
COPY . .

# Instale o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instale dependências do Laravel e configure permissões
RUN composer install --optimize-autoloader --no-dev \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Configure o Nginx (ajuste para refletir o arquivo na raiz)
COPY nginx.conf /etc/nginx/nginx.conf

# Exponha a porta HTTP padrão
EXPOSE 80

# Inicie o PHP-FPM e o Nginx
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]