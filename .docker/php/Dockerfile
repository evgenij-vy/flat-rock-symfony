FROM php:8.2-fpm
WORKDIR '/app'

# UPD AND INSTALL PACKAGE
RUN apt-get update \
    && apt-get install -y apt-utils dialog unzip libicu-dev gnupg2 libzip-dev libpq-dev tzdata openssl\
    && apt-get upgrade -y  \
    # Install YARN
    && curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor > /etc/apt/trusted.gpg.d/yarnkey.gpg \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get update \
    && apt-get -y install nodejs yarn \
    # XDEBUG
    && yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
    # INSTALL APCU
    && yes | pecl install apcu \
    && docker-php-ext-enable apcu \
    && echo "extension=apcu.so" > /usr/local/etc/php/php.ini \
    && echo "apc.enable_cli=1" > /usr/local/etc/php/php.ini \
    && echo "apc.enable=1" > /usr/local/etc/php/php.ini \
    # PHP SQL OPcache intl \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql intl opcache zip \
    # INSTALL COMPOSER
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer  \
    && composer --version