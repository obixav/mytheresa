#!/bin/bash

# Setup and build
docker-compose up -d --build

# Run Composer install
docker-compose exec php composer install

# create .env
docker-compose exec php cp .env.example .env

# generate key
docker-compose exec php php artisan key:generate

# Run Migration and Seed
docker-compose exec php php artisan migrate --seed
