FROM php:8.3-apache

RUN a2enmod rewrite
RUN docker-php-ext-install mysqli

COPY . /var/www/html

RUN sed 's/AllowOverride None/AllowOverride All/' -i /etc/apache2/apache2.conf