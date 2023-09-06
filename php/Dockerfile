FROM php:8.2.9-fpm-alpine
ADD /php/php.ini /usr/local/etc/php/

RUN docker-php-ext-install pdo_mysql mysqli

EXPOSE 9000
CMD ["php-fpm"]