FROM php:8.2-apache

#PHP
RUN apt-get -y update && apt-get -y upgrade
RUN apt-get install -y zlib1g-dev libwebp-dev libpng-dev && docker-php-ext-install gd
RUN apt-get install libzip-dev -y && docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

#Apache
RUN a2enmod rewrite

COPY . /var/www/html

#Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

EXPOSE 80