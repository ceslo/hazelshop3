FROM debian:12

#// 1. Mise à jour de base + outils
RUN apt-get update 
RUN apt install curl wget lsb-release ca-certificates unzip zip -y

# 2. Ajout du dépôt Sury pour PHP (PHP 8.3 à ce jour)
RUN curl -sSLo /tmp/debsuryorg-archive-keyring.deb https://packages.sury.org/debsuryorg-archive-keyring.deb && \
    dpkg -i /tmp/debsuryorg-archive-keyring.deb && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list && \
    apt-get update

# 3. Installation de PHP et extensions nécessaires
RUN apt-get install -y \
    php8.3 \
    php8.3-cli \
    php8.3-mbstring \
    php8.3-intl \
    php8.3-xml \
    php8.3-gd \
    php8.3-curl \
    php8.3-zip \
    php8.3-mysql \
    php8.3-sqlite3 \
    php8.3-xdebug
    
# 4. Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony && \
    symfony server:ca:install

# 5. Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

# 6. Copie de config Xdebug
COPY xdebug.ini /etc/php/8.3/cli/conf.d/20-xdebug.ini

# 7. Dossier de travail
WORKDIR /var/www

# 8. Variables d’environnement
ENV PHP_MEMORY_LIMIT=1024M

# # 9. Commande par défaut : bash (modifiable)
# CMD [ "bash" ]

ENTRYPOINT ["symfony", "server:start", "--allow-all-ip"]