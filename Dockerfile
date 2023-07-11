FROM php:8.2-apache

# Install MySQL and PHP extensions
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y mariadb-server mariadb-client libpng-dev
RUN docker-php-ext-install gd bcmath mysqli pdo_mysql

# Setup Database
COPY ./db/ /tmp/db/
WORKDIR /tmp/db/
RUN service mariadb start && \
    cat setup.sql | mysql --password= && \
    cat migrations/*.sql seeds.sql | mysql --database=npl --password=

# Setup PHP
RUN echo "date.timezone = Europe/Zurich" > /usr/local/etc/php/conf.d/timezone.ini

# Setup Webserver
WORKDIR /var/www/html
ENV APACHE_DOC_ROOT /var/www/html
RUN a2enmod rewrite

# Start Services
CMD service mariadb start && service apache2 start && /bin/bash

EXPOSE 80 80

