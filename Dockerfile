# Use the official PHP image with Apache
FROM php:8.2-apache

# Copy your website files into the web server's root directory
COPY . /var/www/html/

# Ensure Apache can read the files
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 (standard for HTTP)
EXPOSE 80
