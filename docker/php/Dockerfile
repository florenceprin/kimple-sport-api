FROM php:7.4-fpm
ARG TIMEZONE
RUN usermod -u 1000 www-data
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version
# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini
# Install extensions
RUN apt-get update && apt-get install -y libzip-dev
RUN docker-php-ext-install pdo pdo_mysql bcmath zip
# Create an alias for Symfony3 console
RUN echo 'alias symfony="php bin/console"' >> ~/.bashrc
RUN echo 'alias ccache="php bin/console c:c && chown -R www-data:www-data var"' >> ~/.bashrc
WORKDIR /var/www/symfony
