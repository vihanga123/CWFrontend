FROM php:8.2-apache

# Copy application files
COPY index.php /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80d
EXPOSE 80