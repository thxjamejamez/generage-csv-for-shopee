FROM php:7.3-fpm-alpine

RUN apk add --no-cache nginx wget

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app
COPY ./src /app

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN cd /app && \
    /usr/local/bin/composer install --no-dev --ignore-platform-req=ext-gd --ignore-platform-req=ext-zip

RUN chown -R www-data: /app

CMD sh /app/docker/startup.sh
