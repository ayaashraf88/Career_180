FROM php:8.2-apache

# Install system dependencies
RUN apt-get update -y && apt-get install -y \
    git curl zip unzip libpq-dev libzip-dev libonig-dev libicu-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip bcmath intl \
    && a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (for caching)
COPY composer.json composer.lock ./

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies (no scripts yet)
RUN COMPOSER_MEMORY_LIMIT=-1 COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev --no-interaction --no-scripts --prefer-dist

# Copy the rest of the application
COPY . .

# Apache configuration for Laravel
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
