FROM php:7.4-apache

# PHP MySQL extension és PDO MySQL meghajtó telepítése
RUN docker-php-ext-install mysqli pdo_mysql

# HTML, CSS, JS és PHP fájlok másolása a megfelelő helyre
COPY . /var/www/html
COPY src/ /var/www/html/src/

# Jogosultságok beállítása
RUN chown -R www-data:www-data /var/www/html

# Apache konfiguráció
# Apache konfiguráció módosítása a public mappára
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite
