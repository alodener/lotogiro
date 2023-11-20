FROM php:7.4.30-apache

ARG uid
ARG user

RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install zip mysqli pdo pdo_mysql mbstring exif pcntl bcmath gd sockets && docker-php-ext-enable pdo_mysql

WORKDIR /var/www/html

COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

ENV PATH "$PATH:~/.composer/vendor/bin"
USER $user
