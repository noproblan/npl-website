FROM php:5-apache

# Install MySQL and PHP extensions
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y mysql-server mysql-client
RUN docker-php-ext-install mysqli pdo_mysql

# Setup Database
COPY ./db/ /tmp/db/
WORKDIR /tmp/db/
RUN ls
RUN service mysql start && \
    cat setup.sql | mysql --password= && \
    cat migrations/*.sql seeds.sql | mysql --database=npl --password=

# Setup PHP
RUN echo "date.timezone = Europe/Zurich" > /usr/local/etc/php/conf.d/timezone.ini

# Setup Webserver
WORKDIR /var/www/html
ENV APACHE_DOC_ROOT /var/www/html
RUN a2enmod rewrite

# Start Services
CMD service mysql start && apache2-foreground

EXPOSE 80 80

