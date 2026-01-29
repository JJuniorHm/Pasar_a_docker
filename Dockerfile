FROM php:8.1-apache

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    libonig-dev \
    zip \
    unzip \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        mbstring \
        zip \
        intl

# Activar mod_rewrite
RUN a2enmod rewrite

# Copiar proyecto (ya está en la raíz)
COPY . /var/www/html

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
