FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install --quiet --yes --no-install-recommends \
        libzip-dev \
        zlib1g-dev \
        libicu-dev \
        unzip \
    && docker-php-ext-install zip pdo_mysql intl \
    && pecl install -o -f redis-7.2 \
    && docker-php-ext-enable redis

RUN apt-get install -y nodejs

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --chown=app:app package*.json .

RUN groupadd --gid 1000 appuser \
    && useradd --uid 1000 -d /home/appuser -g appuser \
    -G www-data,root --shell /bin/bash \
    --create-home appuser

USER appuser

EXPOSE 9000
