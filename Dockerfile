FROM php:8.3-apache

# PHP extensions
RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Apache rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node.js + npm
RUN apt-get update \
    && apt-get install -y curl \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy Laravel project
COPY . /var/www/html

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Install JS dependencies and build Vite
RUN npm ci
RUN npm run build

# Laravel permissions
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Laravel public directory
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' \
    /etc/apache2/sites-available/000-default.conf

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' \
    /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]