FROM php:8.0-fpm

WORKDIR /var/www

## Install dependencies
RUN apt-get update -y
RUN apt-get install -y \
    build-essential \
    libpng-dev \
    libpq-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl
#xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

#
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
#
## Install extensions
RUN docker-php-ext-install pdo pdo_mysql exif pcntl
RUN docker-php-ext-install gd

#Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer