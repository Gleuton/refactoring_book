FROM php:7.4-apache

WORKDIR /var/www/html/

## Install dependencies
RUN apt-get update && apt-get install -y \
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

#Configure sites Apache
COPY php/configs/apache2.conf /etc/apache2/apache2.conf
COPY php/configs/app.conf /etc/apache2/sites-available/app.conf

#Disable Config default Apache
RUN a2dissite 000-default.conf

#Enable mod rewrite Apache
RUN a2enmod rewrite

#Enable sigtv.conf
RUN a2ensite app.conf

#Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer