FROM php:8.2-apache

# install PDO + Postgres driver
RUN apt-get update && apt-get install -y libzip-dev zlib1g-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# copy app into webroot
COPY . /var/www/html/

# make start.sh executable
RUN chmod +x /var/www/html/start.sh

EXPOSE 80

CMD ["/var/www/html/start.sh"]
