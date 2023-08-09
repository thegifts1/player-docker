FROM php:8.2.8-apache

RUN docker-php-ext-install \
    pdo_mysql \
    && a2enmod \
    rewrite