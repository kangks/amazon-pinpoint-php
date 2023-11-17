# FROM arm64v8/php:8.1-zts-alpine3.16
FROM arm64v8/php:8.1.25-apache-bullseye as base

RUN apt-get update \
    && apt-get -y install git
# && apt-get install -y libmcrypt-dev \
#     mysql-client libmagickwand-dev --no-install-recommends \
#     && pecl install imagick \
#     && docker-php-ext-enable imagick \
# && docker-php-ext-install mcrypt pdo_mysql

# RUN apk update && apk upgrade

# Install Composer
FROM base as composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

FROM composer as runtime

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY src/* /var/www/html
# COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-progress --no-interaction --prefer-dist

EXPOSE 80