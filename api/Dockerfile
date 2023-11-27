FROM php:8.2-fpm as api

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    git curl libz-dev libpq-dev libjpeg-dev libpng-dev libonig-dev libxml2-dev libzip-dev libfreetype6-dev libssl-dev \
    libwebp-dev libxpm-dev libmcrypt-dev libc6 zip unzip supervisor default-mysql-client

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl posix bcmath gd zip

RUN pecl install -o -f redis \ &&  rm -rf /tmp/pear \ &&  docker-php-ext-enable redis

RUN cd ~ \
    && curl -sS https://getcomposer.org/installer | php -- \
    -install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN useradd -G www-data,root -u $uid -d /home/$user $user

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN mkdir -p /var/www/api && \
    chown -R $user:$user /var/www/api
WORKDIR /var/www/api

COPY . .
# COPY ./../devops/local/config/php-fpm/php.ini /usr/local/etc/php/conf.d/php.ini
# COPY ./../devops/local/config/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
# COPY ./../devops/local/bin/update.sh /var/www/api/update.sh

RUN composer update

RUN php artisan storage:link && \
    chmod +x ./update.sh && \
    chown -R $user:$user /var/www/api && \
    chmod -R 775 ./storage ./bootstrap/cache \

USER $user

FROM api AS worker
COPY ../devops/local/config/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisor.conf
CMD ["/bin/sh", "-c", "supervisord -c /etc/supervisor/conf.d/supervisor.conf"]

FROM api AS scheduler
CMD ["/bin/sh", "-c", "nice -n 10 sleep 60 && php /var/www/api/artisan schedule:run --verbose --no-interaction"]
