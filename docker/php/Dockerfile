FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        nodejs \
        npm \
        unzip \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libonig-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring zip gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
