FROM php:8.2-fpm-buster

ARG APP_ENV

ENV APP_DIR /var/www/app

COPY . ${APP_DIR}

WORKDIR ${APP_DIR}

COPY --from=composer:2.4.4 /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && \
    apt-get -y install \
         libpng-dev \
         libzip-dev \
         git \
         zip \
         zlib1g-dev && \
    apt-get clean -y && rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure opcache --enable-opcache &&\
    docker-php-ext-install zip && \
    docker-php-ext-install \
        gd \
        opcache

RUN if [ ${APP_ENV} = 'dev' ]; then \
    export PHP_XDEBUG_CONFIG_FILE=${PHP_INI_DIR}/conf.d/docker-php-ext-xdebug.ini; \
    export PHP_XDEBUG_VERSION=3.2; \
    apt-get update && \
    apt-get clean -y && \
    rm -rf /var/lib/apt/lists/* && \
    pecl install -o -f xdebug-${PHP_XDEBUG_VERSION} && \
    docker-php-ext-enable xdebug && \
    cp ./docker/php/config/xdebug.ini ${PHP_XDEBUG_CONFIG_FILE}; \
  fi

RUN cp ./docker/php/config/op-cache.ini ${PHP_INI_DIR}/conf.d/op-cache.ini && \
    cp ./docker/php/config/fpm.ini ${PHP_INI_DIR}/conf.d/

RUN if [ ${APP_ENV} = 'prod' ]; then \
    echo "opcache.preload=${APP_DIR}/config/preload.php" >> ${PHP_INI_DIR}/conf.d/op-cache.ini \
  ;fi

RUN set -ex && \
    sed -i -e "/access.log\s*=[^\n]*/s/^/;/g" /usr/local/etc/php-fpm.d/docker.conf && \
    php-fpm --test

RUN php -v && \
    php -m \
