FROM serversideup/php:8.5-fpm-nginx-alpine

USER root

# Install the intl and bcmath extensions with root permissions
RUN install-php-extensions intl gd sockets
RUN apk update && apk add mariadb-client postgresql17-client pgloader

# Drop back to our unprivileged user
USER www-data

WORKDIR /app