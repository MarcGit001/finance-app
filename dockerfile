FROM php:8.2-cli

# Installer dépendances
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le projet
WORKDIR /app
COPY . .

# Installer Laravel
RUN composer install --no-dev --optimize-autoloader

# Exposer port
EXPOSE 10000

# Lancer serveur Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000