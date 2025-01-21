FROM php:8.2

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /app

# Set working directory
WORKDIR /app

RUN composer install

RUN composer dump-autoload

#CMD ["php", "-a"]
CMD ["php", "index.php", "input.jsonl"]
