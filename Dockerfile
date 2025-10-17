FROM php:8.3-apache

# (Opcional) extensiones que podrías usar más adelante
RUN docker-php-ext-install pdo pdo_mysql

# Apache listo para URLs lindas (.htaccess)
RUN a2enmod rewrite \
 && sed -ri 's/AllowOverride None/AllowOverride All/i' /etc/apache2/apache2.conf

# Usar public como DocumentRoot
RUN sed -ri 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#' /etc/apache2/sites-available/000-default.conf \
 && sed -ri 's#<Directory /var/www/html/>#<Directory /var/www/html/public/>#' /etc/apache2/apache2.conf

# Copiá el proyecto
WORKDIR /var/www/html
COPY . /var/www/html

