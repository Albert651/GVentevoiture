# Utilise l'image officielle PHP avec Apache
FROM php:8.2-apache

# Installe l'extension mysqli
RUN docker-php-ext-install mysqli

# Active le module rewrite d’Apache si tu en as besoin (ex: pour des routes propres)
RUN a2enmod rewrite

# Copie les fichiers de ton projet dans le dossier du serveur Apache
COPY . /var/www/html/

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html

# Expose le port utilisé par Apache
EXPOSE 80
