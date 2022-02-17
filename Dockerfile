FROM php:7.4-fpm

RUN apt-get update

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libzip-dev \
    zip \
    unzip \
    nano \
    ghostscript \
    default-mysql-client

# Install PHP extensions
RUN apt-get install -y \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mysqli mbstring exif zip pcntl bcmath gd soap

## Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install XDebug for PHPUnit Code Coverage
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# Set working directory
WORKDIR /var/www/html

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -ms /bin/bash -d /home/luffy luffy
RUN mkdir -p /home/luffy/.composer && \
    chown -R luffy:www-data /var/www/html

USER luffy
