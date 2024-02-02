FROM php:8.2-fpm

RUN apt-get update
RUN apt-get install -y curl git libzip-dev libicu-dev
RUN docker-php-ext-install intl zip opcache
RUN pecl install xdebug && echo "zend_extension=xdebug.so" > $PHP_INI_DIR/conf.d/xdebug.ini
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
RUN usermod --shell /bin/bash www-data

WORKDIR /app

COPY . .

RUN composer install

ENTRYPOINT [ "symfony", "server:start" ]