FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        libpq-dev \
        wget \
        zlib1g-dev \
        libmcrypt-dev \
        git \
        && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

RUN usermod -u 1000 www-data && mkdir /var/www/hltv
WORKDIR /var/www/hltv

COPY entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/

ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]
