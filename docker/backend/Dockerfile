FROM php:8.3-apache

ARG UID

# Create user with same permissions as host and some useful stuff
RUN adduser -u ${UID} --disabled-password --gecos "" appuser
RUN mkdir /home/appuser/.ssh
RUN chown -R appuser:appuser /home/appuser/
RUN echo "StrictHostKeyChecking no" >> /home/appuser/.ssh/config
RUN echo "alias sf=/var/www/html/bin/console" >> /home/appuser/.bashrc

# Install packages and PHP extensions
RUN apt update \
    # common libraries and extensions
    && apt install -y git acl openssl openssh-client wget zip \
    && apt install -y libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev \
    && docker-php-ext-install intl pdo zip \
    # for MySQL
    && docker-php-ext-install pdo_mysql \
    # XDEBUG and APCu
    && pecl install xdebug apcu \
    # enable Docker extensions
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache xdebug apcu

# Install and update composer
RUN curl https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN composer self-update

## Install Symfony binary
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli

RUN mkdir -p /var/www/html

# Update Apache config
COPY ./default.conf /etc/apache2/sites-available/default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && a2enmod rewrite \
    && a2dissite 000-default \
    && a2ensite default \
    && service apache2 restart

# Config XDEBUG
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
# Modify upload file size
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html

COPY wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

CMD ["bash", "-lc", "\
  composer install --optimize-autoloader && \
  /usr/local/bin/wait-for-it.sh app-mysql:3306 --timeout=30 --strict -- php bin/console app:db:init --test && \
  php bin/console doctrine:fixtures:load -n && \
  exec apache2-foreground \
"]
