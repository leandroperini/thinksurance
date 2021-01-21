FROM php:7.4-fpm

COPY docker/php/php.ini /usr/local/etc/php/conf.d/php.ini

RUN apt update && apt -y install wget git && \
wget https://get.symfony.com/cli/installer -O - | bash && \
mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN docker-php-ext-install \
    pdo pdo_mysql

RUN pecl install xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/thinksurance
