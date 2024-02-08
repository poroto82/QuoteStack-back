FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copia solo los archivos necesarios para aprovechar la caché de Docker
COPY composer.json composer.lock ./

# Copia el resto de la aplicación
COPY . .


# Instala las dependencias de Composer
RUN composer install 


# Opta por la eliminación de los archivos y directorios innecesarios para producción
RUN rm -rf docker/ tests/ .git/ .env.example .gitignore

# Cambia los permisos para garantizar que el contenedor pueda escribir en ciertos directorios
RUN chown -R www-data:www-data storage bootstrap/cache

# Configura PHP-FPM para que escuche en un socket en lugar de en un puerto
RUN sed -i 's/^listen = .*/listen = \/var\/www\/php-fpm.sock/' /usr/local/etc/php-fpm.d/www.conf

# Expone el socket de PHP-FPM
EXPOSE 9000

# Inicia PHP-FPM
CMD ["php-fpm"]
