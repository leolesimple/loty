FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli zip \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Redirige les logs Apache vers stdout/stderr pour docker logs
RUN ln -sf /dev/stdout /var/log/apache2/access.log \
    && ln -sf /dev/stderr /var/log/apache2/error.log

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

COPY --chown=www-data:www-data . /var/www/html/

RUN chmod -R 755 /var/www/html \
    && a2ensite 000-default

EXPOSE 80
