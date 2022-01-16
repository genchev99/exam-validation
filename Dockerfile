FROM php:8.1.1-apache

# Support mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www/html

COPY src/ /var/www/html
