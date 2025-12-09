FROM php:8.2-apache

# PHP extensionök telepítése (ha szükséges)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# A projekt fájljai bemásolása a webrootba
COPY . /var/www/html/

# Apache mod_rewrite engedélyezése, ha kell
RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]
