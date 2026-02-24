FROM dunglas/frankenphp:php8.2

# Install dependencies sistem dan ekstensi PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

RUN apt-get update && apt-get install -y nodejs npm && rm -rf /var/lib/apt/lists/*
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files dulu untuk cache layer
COPY composer.json composer.lock ./

# Install dependencies dengan opsi untuk handle error
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts || (echo "Composer install failed" && exit 1)

# Copy aplikasi Laravel
COPY . /app

# Jalankan post-install scripts jika diperlukan
RUN composer run-script post-install-cmd --no-dev || true

# Set permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage

# Expose port
EXPOSE 80
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile", "--adapter", "caddyfile"]