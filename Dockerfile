# Utilise l'image officielle PHP avec Apache
FROM php:8.2-apache

# Installe les extensions nécessaires pour MySQL
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Active le module rewrite d’Apache
RUN a2enmod rewrite

# Copie les fichiers dans le dossier du serveur Apache
COPY . /var/www/html/

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html

# Expose le port utilisé par Apache
EXPOSE 80
