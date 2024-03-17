FROM php:8.3-apache-bullseye

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update \
  && apt-get install -y libpq-dev libzip-dev git wget unzip p7zip --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo pdo_pgsql zip;
RUN docker-php-ext-enable opcache;

COPY docker-php-entrypoint /usr/local/bin/
COPY apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY . /var/www/html

ARG PROJECT_DIR_ARG='/var/www/html'
ENV PROJECT_DIR=$PROJECT_DIR_ARG

WORKDIR $PROJECT_DIR