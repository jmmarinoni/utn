FROM php:7.4-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    default-mysql-client \
    curl \
    zip \
    sudo \
    netcat \
    cron

RUN docker-php-ext-install pdo_mysql mysqli

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY site/app /var/www/html

COPY site/init.sql /docker-entrypoint-initdb.d/init.sql

COPY site/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
