# Escolhe a imagem base do PHP com FPM (FastCGI Process Manager)
FROM php:7.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copia todos os arquivos do projeto para dentro do container
COPY . /var/www/html

# Install dependencies
RUN composer install --no-interaction --no-dev --prefer-dist

# Ajusta permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Expõe a porta do PHP-FPM (opcional)
EXPOSE 9000

# Comando padrão ao iniciar o container
CMD ["php-fpm"]
