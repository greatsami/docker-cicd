FROM php:8.2-fpm as api

WORKDIR /var/www/api

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libc6 \
    zip \
    unzip \
    supervisor \
    default-mysql-client

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl posix bcmath gd zip

RUN pecl install redis

COPY --from=composer:2.5.8 /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN mkdir -p /var/www/api && \
    chown -R $user:$user /var/www/api

COPY ./api/composer*.json /var/www/api
COPY ./devops/local/config/php-fpm/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./devops/local/config/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./devops/local/bin/update.sh /var/www/api/update.sh

RUN composer install --no-scripts

COPY ./api .

RUN chmod +x ./update.sh
RUN chmod -R 775 ./storage ./bootstrap/cache

USER $user

FROM api AS worker
COPY ../devops/local/config/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisor.conf
CMD ["/bin/sh", "-c", "supervisord -c /etc/supervisor/conf.d/supervisor.conf"]

FROM api AS scheduler
CMD ["/bin/sh", "-c", "nice -n 10 sleep 60 && php /var/www/api/artisan schedule:run --verbose --no-interaction"]
