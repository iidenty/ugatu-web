FROM php:8.1-fpm-alpine

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN apk update && apk add autoconf g++ make icu-dev libpq libzip-dev zip \
    && rm -rf /tmp/pear \
    && docker-php-ext-install intl zip

RUN apk update && apk add unzip

COPY ./php-fpm/conf.d /usr/local/etc/php/conf.d

WORKDIR /app
