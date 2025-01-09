# Etapa 1: Construção da imagem com PHP-FPM e dependências
FROM php:8.2-fpm AS base

# Instale dependências do sistema e extensões do PHP
RUN apt-get update && apt-get install -y \
    nginx \
    libpq-dev \
    unzip \
    && docker-php-ext-install pdo_pgsql

# Configure o ambiente de trabalho
WORKDIR /var/www/html

# Copie arquivos de configuração do Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf

# Instale o Composer (usando imagem oficial do Composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copie os arquivos do projeto
COPY . .

# Configure permissões e dependências do Laravel
RUN composer install --optimize-autoloader --no-dev \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Exponha a porta 80 para o Nginx
EXPOSE 80

# Certifique-se de que o binário Nginx está no PATH
RUN ln -s /usr/sbin/nginx /usr/bin/nginx

# Comando de inicialização para Nginx e PHP-FPM
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]