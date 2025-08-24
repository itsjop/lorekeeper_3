#!/bin/bash

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
MAX_RETRIES=30
RETRY_COUNT=0

while ! nc -z db 3306; do
  RETRY_COUNT=$((RETRY_COUNT+1))
  if [ $RETRY_COUNT -eq $MAX_RETRIES ]; then
    echo "Error: Maximum retry count reached. MySQL is not available. Check MySQL logs for errors."
    echo "Continuing anyway, but database operations may fail..."
    break
  fi
  echo "Waiting for database connection... (Attempt $RETRY_COUNT/$MAX_RETRIES)"
  sleep 5
done

if [ $RETRY_COUNT -lt $MAX_RETRIES ]; then
  echo "MySQL is up and running!"
  # Additional check to verify MySQL is accepting connections
  sleep 2
  if ! mysql -h db -u lorekeeper -psecret -e "SELECT 1" >/dev/null 2>&1; then
    echo "Warning: MySQL is running but not accepting connections. Some database operations may fail."
  else
    echo "MySQL connection verified successfully!"
  fi
fi

cd ~/Documents/code/lorekeeper/lorekeeper_3

# Copy .env.example to .env if .env doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env

    # Update database connection settings
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/g' .env
    sed -i 's/DB_DATABASE=homestead/DB_DATABASE=lorekeeper/g' .env
    sed -i 's/DB_USERNAME=homestead/DB_USERNAME=lorekeeper/g' .env
    sed -i 's/DB_PASSWORD=secret/DB_PASSWORD=secret/g' .env

    # Add required settings from README
    echo "CONTACT_ADDRESS=example@example.com" >> .env
    echo "DEVIANTART_ACCOUNT=example" >> .env
fi

# Install dependencies
echo "Installing dependencies..."
composer install --no-interaction --dev --optimize-autoloader

# Generate key if not already generated
if grep -q "APP_KEY=base64:" .env; then
    echo "Application key already exists."
else
    echo "Generating application key..."
    php artisan key:generate
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Add basic site data
echo "Adding basic site data..."
php artisan add-site-settings
php artisan add-text-pages
php artisan copy-default-images

# Set permissions
echo "Setting permissions..."
chmod -R 777 storage bootstrap/cache

# Compile assets
echo "Compiling assets..."
npm install
npm run prod

echo "Setup completed!"

# Start PHP-FPM
php-fpm
