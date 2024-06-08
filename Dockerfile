FROM php:8.1-cli-alpine

RUN apk --no-cache add \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

CMD ["php", "-a"]
