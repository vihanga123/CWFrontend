# Use official PHP 8.2 with Apache
FROM php:8.2-apache

# Copy application code
COPY ./ /var/www/html/

# Fix permissions: Apache runs as www-data
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite   # enable mod_rewrite if your app uses pretty URLs

# Create a proper health-check file (critical for Kubernetes probes)

# Expose port 80 (correct, no "d")
EXPOSE 80
 
# Optional: make Apache run in foreground (default behavior, but explicit is nice)
CMD ["apache2-foreground"]