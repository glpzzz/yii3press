FROM php:8.1-apache

RUN apt-get update && \
    apt-get install -y libzip-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install mysqli zip calendar && \
    a2enmod rewrite
RUN pecl install xdebug-3.1.5 && \
    docker-php-ext-enable xdebug

RUN echo 'xdebug.mode=develop,coverage,debug \n\
xdebug.discover_client_host=true \n\
xdebug.client_host=host.docker.internal \n\
xdebug.client_port=9003 \n\
xdebug.start_with_request=yes' >>  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# install wp-cli
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp

# setup wordpress website and page
RUN wp core download --path=/var/www/html --allow-root
    wp config create --dbhost=mysql --dbname=yii3press --dbuser=yii3press --dbpass=secret --allow-root && \
    wp core install --url=127.0.0.1:23080 --title="Yii3 Press" --admin_user=yii3press --admin_password=yii3press --admin_email=admin@localhost.com --skip-email --allow-root && \
    wp post create --post_type=page --post_title='The Rating Form' --post_status="publish" --allow-root

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
