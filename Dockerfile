FROM php:8.1.1-apache

WORKDIR /var/www/html

COPY src/ /var/www/html
