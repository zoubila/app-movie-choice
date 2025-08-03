# Utiliser l'image PHP avec Apache
FROM php:8.3-apache

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Installer les extensions et outils manquants
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql zip


# Installer Node.js et npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Installer Webpack Encore
RUN npm install -g yarn

RUN pecl install xdebug && docker-php-ext-enable xdebug

# Copier les fichiers de configuration existants
COPY php.ini /usr/local/etc/php/php.ini
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Activer les modules Apache si nécessaire
RUN a2enmod rewrite
