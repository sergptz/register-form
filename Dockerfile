FROM php:7.4-cli AS builder

RUN apt-get update && apt-get install -y \
    build-essential \
    curl \
    libzip-dev \
    unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo zip pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

FROM node:14-alpine

COPY --from=builder . .

RUN mkdir -p /app
WORKDIR /app

COPY . .

RUN composer install

RUN npm install

RUN mkdir -p /app/images

EXPOSE 3000

CMD ["php", "-S", "0.0.0.0:3000"]