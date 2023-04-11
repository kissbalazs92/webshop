FROM php:7.4-apache

# PHP MySQL extension és PDO MySQL meghajtó telepítése
RUN docker-php-ext-install mysqli pdo_mysql

COPY php.ini /usr/local/etc/php/php.ini

# HTML, CSS, JS és PHP fájlok másolása a megfelelő helyre
COPY . /var/www/html

# Jogosultságok beállítása
RUN chown -R www-data:www-data /var/www/html

# Uploads könyvtár jogosultságainak beállítása
RUN mkdir -p /var/www/html/public/uploads && chmod 755 /var/www/html/public/uploads

# Apache konfiguráció
# Apache konfiguráció módosítása a public mappára
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite
