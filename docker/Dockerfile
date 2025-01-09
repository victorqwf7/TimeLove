FROM php:8.2-fpm

# Instale dependências do sistema e PHP
RUN apt-get update && apt-get install -y \
    nginx \
    libpq-dev \
    unzip \
    && docker-php-ext-install pdo_pgsql

# Configure o PHP e Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf

# Configure o ambiente
WORKDIR /var/www/html
COPY . .

# Instale o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure permissões e dependências do Laravel
RUN composer install --optimize-autoloader --no-dev \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Exponha a porta 80 para o Nginx
EXPOSE 80

# Comando de inicialização
CMD ["nginx", "-g", "daemon off;"]