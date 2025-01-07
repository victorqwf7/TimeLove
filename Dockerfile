# Usa a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instala extensões necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia os arquivos do projeto para o container
COPY . /var/www/html

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala dependências do Laravel
RUN composer install --no-scripts --no-interaction --optimize-autoloader

# Permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Ativa o módulo rewrite do Apache
RUN a2enmod rewrite

# Porta padrão do Apache
EXPOSE 80