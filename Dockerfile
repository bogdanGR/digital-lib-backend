# Start from PHP 8.2 FPM base image
FROM php:8.2-fpm

# Set working directory inside the container
WORKDIR /var/www/html

# Install required packages including poppler-utils (for pdftotext)
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
        zlib1g-dev \
        libicu-dev \
        unzip \
        poppler-utils \
    && docker-php-ext-install zip pdo_mysql intl \
    && pecl install -o -f redis-7.2 \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js (adjust version as needed)
RUN apt-get update && apt-get install -y nodejs

# Copy package.json and package-lock.json files
COPY --chown=app:app package*.json ./

# Install Composer (adjust path if necessary)
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Create appuser with appropriate permissions
RUN groupadd --gid 1000 appuser \
    && useradd --uid 1000 -d /home/appuser -g appuser \
    -G www-data,root --shell /bin/bash \
    --create-home appuser

# Switch to the appuser
USER appuser

# Copy php.ini configuration file
COPY .docker/php.ini /usr/local/etc/php/php.ini

EXPOSE 9000
