FROM php:8.2-fpm

WORKDIR /var/www/html

COPY composer.json composer.json

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
