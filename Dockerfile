FROM php:8.4-apache

# 1. Install all system dependencies, Node.js, and Composer in one clean layer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    zip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip mbstring xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 2. Configure Apache
RUN a2enmod rewrite

RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' /etc/apache2/sites-available/000-default.conf

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

RUN printf '<Directory /var/www/html/public>\n\
AllowOverride All\n\
Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

WORKDIR /var/www/html

# 3. Cache PHP Dependencies (Drastically speeds up subsequent builds)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

# 4. Cache Frontend Dependencies
COPY package.json package-lock.json* ./
RUN npm ci

# 5. Copy the rest of your application code
COPY . .

# 6. Finish Composer optimization & build frontend assets
# This handles the "--optimize-autoloader --no-dev" part of your request perfectly
RUN composer dump-autoload --optimize --no-dev
RUN npm run build

# 7. Pre-clear caches during build (to ensure old local caches aren't baked in)
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# 8. Set up permissions properly
RUN mkdir -p storage/framework/cache storage/framework/sessions \
    storage/framework/views bootstrap/cache public/uploads \
    && chown -R www-data:www-data storage bootstrap/cache public/uploads \
    && chmod -R 775 storage bootstrap/cache public/uploads

EXPOSE 10000

# 9. RUNTIME COMMANDS (Executes *only* when the container boots up, not during build)
# This safely handles: storage linking, production configuration caching, and migrations.
CMD php artisan storage:link --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force \
    && apache2-foreground