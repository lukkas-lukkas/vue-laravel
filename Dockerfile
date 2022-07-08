FROM php:8.0.0-fpm-alpine3.12

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk --update add --no-cache \
    ${PHPIZE_DEPS} \
    curl \
    zip \
    nginx \
    bash \
    git \
    sqlite \
    && rm -rf /var/cache/apk/* \
    && mkdir /run/nginx

RUN docker-php-ext-install pdo

COPY /config/nginx /etc/nginx/conf.d
COPY /config/docker /docker
COPY /application /application

RUN chmod -R 777 /docker

WORKDIR /application

EXPOSE 9001

ENTRYPOINT ["/bin/bash", "/docker/entrypoint.sh"]