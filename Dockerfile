# When this file is changed, the image for develop is changed automatically

FROM existenz/webstack:8.2

# make user match with typical debian/ubuntu setup and allow to login/su to php (needed for SSH)
RUN sed -i 's/php:x:101:102:Linux User,,,:\/home\/php:\/sbin\/nologin/php:x:1000:1000:Linux User,,,:\/home\/php:\/bin\/ash/' /etc/passwd \
    && sed -i 's/php:x:102/php:x:1000/' /etc/group \
    && chown -R php:php /home/php

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# need the PHP cli to have bin/console work
RUN apk -U upgrade && apk add --no-cache \
        tzdata \
        icu-data-full \
        parallel \
        postgresql-client \
        php82 \
        php82-apcu \
        php82-ctype \
        php82-curl \
        php82-dom \
        php82-intl \
        php82-iconv \
        php82-opcache \
        php82-json \
        php82-mbstring \
        php82-pdo_pgsql \
        php82-phar \
        php82-session \
        php82-simplexml \
        php82-tokenizer \
        php82-xml \
        php82-xmlwriter \
        php82-zip

RUN ln -sf /usr/bin/php82 /usr/bin/php
RUN adduser -D -S -G www-data www-data
RUN mkdir /home/php/.parallel && touch /home/php/.parallel/will-cite # suppress notice from parallel

ARG PHP_INI_DIR=/etc/php82

ENV TZ=Europe/Zurich
ENV APP_ENV=dev XDEBUG_MODE=off

COPY docker/php/conf.d/app.ini $PHP_INI_DIR/conf.d/
COPY docker/nginx/nginx.conf /etc/nginx/
