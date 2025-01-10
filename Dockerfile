# Use uma imagem oficial do PHP com FPM
FROM php:8.2-fpm

# Remova o Apache e instale o Nginx
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    apt-get update --fix-missing && \
    apt-get purge -y apache2 && \
    apt-get install -y --no-install-recommends \
        nginx \
        libpq-dev \
        unzip && \
    docker-php-ext-install pdo_pgsql && \
    apt-get autoremove -y && \
    apt-get clean

# Configure o ambiente
WORKDIR /var/www/html

# Copie os arquivos do projeto
COPY . .

# Instale o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure permissões do Laravel
RUN composer install --optimize-autoloader --no-dev && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html

# Configure o Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf

# Exponha a porta 80
EXPOSE 80

# Inicialize o Nginx e o PHP-FPM
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]