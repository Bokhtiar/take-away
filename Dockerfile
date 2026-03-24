# Use official PHP image (no Apache since we're using artisan serve)
FROM php:8.2-cli

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies (will be overridden by volume, but needed for initial build)
RUN composer install --no-interaction --optimize-autoloader --no-dev || true

# Copy project files to container
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 8000
EXPOSE 8000

# Create entrypoint script
RUN echo '#!/bin/sh\n\
if [ ! -f /var/www/html/vendor/autoload.php ]; then\n\
    echo "Installing composer dependencies..."\n\
    composer install --no-interaction --optimize-autoloader\n\
fi\n\
php artisan config:clear\n\
php artisan cache:clear\n\
exec php artisan serve --host=0.0.0.0 --port=8000' > /entrypoint.sh \
    && chmod +x /entrypoint.sh

# Run Laravel server
ENTRYPOINT ["/entrypoint.sh"]
