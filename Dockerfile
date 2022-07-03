FROM php:8.0.0-fpm-alpine3.12

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer