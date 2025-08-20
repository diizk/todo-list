FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    git \
    curl \
    oniguruma-dev \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    sqlite-dev \
    $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install pdo pdo_mysql zip exif pcntl opcache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer