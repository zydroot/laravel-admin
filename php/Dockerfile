FROM php:7.2-apache
COPY php.ini /usr/local/etc/php/
COPY sites.apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY sources.list /etc/apt/sources.list
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load \
  && apt-get update \
  && apt-get install -y libfreetype6-dev libpng-dev libjpeg-dev \
  && docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr --with-freetype-dir=/usr  \
  && docker-php-ext-install pdo_mysql mysqli gd zip \
  && pecl install swoole \
  && docker-php-ext-enable swoole