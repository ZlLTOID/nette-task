FROM php:8.1-fpm-alpine

RUN apk add mariadb-client && \
    apk add mariadb-connector-c && \
    apk add --update nodejs npm && \
    apk add chromium

RUN apk add --update gcc g++ make python3 && \
    apk add gcompat

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql && \
    install-php-extensions intl && \
    install-php-extensions gd && \
    install-php-extensions zlib && \
    install-php-extensions zip && \
    install-php-extensions sockets


RUN wget https://getcomposer.org/installer -O - | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/php.ini
ADD php-fpm.conf /etc/php/php-fpm.d/

WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm", "-F"]
