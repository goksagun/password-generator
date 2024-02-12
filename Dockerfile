# Use the official PHP image.
# https://hub.docker.com/_/php
FROM php:8.2-apache

ENV PORT 8080
ENV PROJECT_ROOT /var/www/project
ENV APACHE_DOCUMENT_ROOT "$PROJECT_ROOT/public"
ENV APP_ENV prod
ENV COMPOSER_ALLOW_SUPERUSER 1

# Update and install additional requirements.
RUN apt-get update \
    && apt-get autoremove -y \
    && apt-get install git -y \
    && apt-get install zip -y \
    # && apt-get install libpq-dev -y \
    && apt-get install gnupg2 -y \
    && curl -fsSL https://deb.nodesource.com/setup_19.x | bash -
    #&& curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    #&& echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

# Update and install node and yarn package managers.
RUN apt-get update && apt-get install -y nodejs

# Configure PHP for Cloud Run.
# Precompile PHP code with opcache.
RUN docker-php-ext-install -j "$(nproc)" opcache

# Install other extensions.
RUN pecl install apcu  \
    && docker-php-ext-enable apcu

# Copy cloud-run php configurations.
COPY docker/php/cloud-run.ini "$PHP_INI_DIR/conf.d/cloud-run.ini"

# Copy in custom code from the host machine.
WORKDIR $PROJECT_ROOT
COPY . ./

# Composer install requirements.
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Run composer install.
RUN export APP_ENV=$APP_ENV  \
    && composer install --no-dev --optimize-autoloader \
    && composer dump-env $APP_ENV \
    && npm install  \
    && php bin/console tailwind:build --minify \
    && php bin/console asset-map:compile

# Copy Apache default virtual host configuration.
COPY docker/apache/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/apache/ports.conf /etc/apache2/ports.conf

# Use the PORT environment variable in Apache configuration files.
# https://cloud.google.com/run/docs/reference/container-contract#port
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
# Use the PROJECT_ROOT environment variable to change the default DocumentRoot in Apache (away from /var/www/html).
RUN sed -ri -e 's!/var/www/html!${PROJECT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Configure PHP for development.
# Switch to the production php.ini for production operations.
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
# https://github.com/docker-library/docs/blob/master/php/README.md#configuration
#RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

EXPOSE 8080
