FROM php:8.2-cli-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
        bash \
        git \
        unzip \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libwebp-dev \
        libzip-dev \
        icu-dev \
        oniguruma-dev \
        libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
        gd \
        pdo_mysql \
        zip \
        bcmath \
        intl \
        mbstring \
        xml \
        exif \
        pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
