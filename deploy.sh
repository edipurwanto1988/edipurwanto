#!/bin/bash

# Laravel Blog Deployment Script
# This script handles proper deployment including Vite build

echo "Starting deployment..."

# Navigate to project directory
cd /path/to/your/project

# Install dependencies
echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader
npm install

# Build Vite assets for production
echo "Building Vite assets for production..."
npm run build

# Clear cache
echo "Clearing application cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run migrations (optional - be careful with this in production)
# php artisan migrate --force

# Optimize application
echo "Optimizing application..."
php artisan route:cache
php artisan config:cache
php artisan event:cache

echo "Deployment completed successfully!"