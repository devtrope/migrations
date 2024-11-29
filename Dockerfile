FROM php:8.2-apache

#PHP
RUN apt-get -y update && apt-get -y upgrade
RUN apt-get install -y zlib1g-dev libwebp-dev libpng-dev && docker-php-ext-install gd
RUN apt-get install libzip-dev -y && docker-php-ext-install zip

#Apache
RUN a2enmod rewrite
RUN echo "ServerName docker.test" >> /etc/apache2/conf-available/servername.conf && a2enconf servername

COPY . /var/www/html

#Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

EXPOSE 80