FROM php:7.4-fpm

RUN apt-get update -y \
    && apt-get install -y nginx \
    && apt-get -y install git

RUN mkdir /usr/local/nvm

ENV PHP_CPPFLAGS="$PHP_CPPFLAGS -std=c++11"
ENV NVM_DIR /usr/local/nvm
ENV NODE_VERSION 20.9.0

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install opcache \
    && apt-get install libicu-dev -y \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apt-get remove libicu-dev icu-devtools -y
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/php-opocache-cfg.ini

RUN curl --silent -o- https://raw.githubusercontent.com/creationix/nvm/v0.39.5/install.sh | bash

RUN . $NVM_DIR/nvm.sh \
    && nvm install $NODE_VERSION \
    && nvm alias default $NODE_VERSION \
    && nvm use default

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

ENV NODE_PATH $NVM_DIR/v$NODE_VERSION/lib/node_modules
ENV PATH $NVM_DIR/versions/node/v$NODE_VERSION/bin:$PATH

COPY docker/php/nginx-site.conf /etc/nginx/sites-enabled/default
COPY docker/php/entrypoint.sh /etc/entrypoint.sh

RUN chmod +x /etc/entrypoint.sh

WORKDIR /var/www/app

# prevent the reinstallation of vendors at every changes in the source code
COPY --link composer.* ./
COPY --link frontend/package-lock.json frontend/package.json ./frontend/
RUN set -eux; \
	composer install --no-cache --no-dev --no-scripts; \
    cd frontend; \
    npm i; \
    cd -;

COPY --chown=www-data:www-data . .

RUN set -eux; \
	mkdir -p var/cache var/log; \
    chown -R www-data:www-data var; \
    cd frontend; \
    npm run build; \
    cd -; \
    cp -r frontend/build/* public/;

EXPOSE 80 443

ENTRYPOINT ["sh", "/etc/entrypoint.sh"]