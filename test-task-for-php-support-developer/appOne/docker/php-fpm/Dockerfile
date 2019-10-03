FROM php:7.2-fpm-stretch

# Permissions
RUN usermod -u 1000 www-data \
    && groupmod -g 1000 www-data

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install \
    apt-utils \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && apt-get clean; rm -rf /var/lib/apt/lists/*