#!/bin/sh

set -e

if [ "$1" = 'php-fpm' ] || [ "$1" = 'bin/console' ]; then
  mkdir -p var/cache var/log
  composer install
  chown -R www-data var
fi

exec docker-php-entrypoint "$@"
