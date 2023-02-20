FROM php:7.3-fpm-alpine

# Add Repositories
RUN rm -f /etc/apk/repositories &&\
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.15/main" >> /etc/apk/repositories && \
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.15/community" >> /etc/apk/repositories

# Add Dependencies
RUN apk add --update --no-cache \
    gcc \
    g++ \
    make \
    python3 \
    nano \
    bash \
    nodejs \
    npm \
    git \
    nginx \
    wget

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app
COPY ./src /app

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN cd /app && \
    npm install
RUN cd /app && \
    /usr/local/bin/composer install --no-dev --ignore-platform-req=ext-gd --ignore-platform-req=ext-zip

RUN chown -R www-data: /app

CMD sh /app/docker/startup.sh
