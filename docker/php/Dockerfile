FROM php:7.4-fpm

RUN apt update && \
apt -y install wget git libzip-dev unzip && \
wget https://get.symfony.com/cli/installer -O - | bash && \
mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN docker-php-ext-install pdo pdo_mysql zip

RUN pecl install xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/thinksurance
