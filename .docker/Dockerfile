FROM php:8.4-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd xdebug zip pdo_mysql intl openssl soap bcmath timezonedb

# INSTALL COMPOSER
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# WORK DIR
WORKDIR /var/www/

# PATH
ENV PATH="/var/www/vendor/bin:${PATH}"

# MEMORY LIMIT
RUN echo "memory_limit=2G" > /usr/local/etc/php/conf.d/99-memory-limit.ini

# KEEP HYSTORY COMMAND
RUN ln -sf /bin/bash /bin/sh