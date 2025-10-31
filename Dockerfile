# Use official PHP 8.2 with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite headers

# Configure Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set proper permissions for web directory
RUN chown -R www-data:www-data /var/www/html

# Configure PHP
RUN echo "upload_max_filesize = 10M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 10M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/errors.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini

# Copy application files
COPY . /var/www/html/

# Set permissions for data directory
RUN chmod -R 755 /var/www/html/data \
    && chown -R www-data:www-data /var/www/html/data

# Expose port 80
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
