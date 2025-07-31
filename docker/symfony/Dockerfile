FROM php:8.4-fpm-alpine

# Instalacja zależności systemowych
RUN apk add --no-cache \
    bash \
    icu-dev \
    libxml2-dev \
    oniguruma-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install intl pdo pdo_mysql opcache

# Instalacja Composera
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html



# Ustawienia produkcyjne
ENV APP_ENV=prod

CMD ["php-fpm"]
