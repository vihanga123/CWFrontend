# Use official PHP 8.2 with Apache
FROM php:8.2-apache

# Copy application code
COPY ./ /var/www/html/

# Fix permissions: Apache runs as www-data
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite   # enable mod_rewrite if your app uses pretty URLs

EXPOSE 80
 