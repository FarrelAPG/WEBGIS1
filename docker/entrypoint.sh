#!/usr/bin/env bash
set -e

PORT=${PORT:-80}
echo "Konfigurasi Nginx port: $PORT"
sed -i "s/LISTEN_PORT/$PORT/g" /etc/nginx/sites-available/default

# Pastikan direktori database ada
mkdir -p /var/www/html/database

# Inisialisasi SQLite jika belum ada
if [ ! -f /var/www/html/database/database.sqlite ]; then
    echo "Membuat database SQLite awal & menjalankan seeder..."
    touch /var/www/html/database/database.sqlite
    chown -R www-data:www-data /var/www/html/database
    chmod 664 /var/www/html/database/database.sqlite
    php artisan migrate --force --seed
else
    echo "Database SQLite terdeteksi, menjalankan migrasi..."
    chown -R www-data:www-data /var/www/html/database
    chmod 664 /var/www/html/database/database.sqlite
    php artisan migrate --force
fi

# Pastikan direktori storage dan izin www-data
mkdir -p /var/www/html/storage/framework/sessions /var/www/html/storage/framework/views /var/www/html/storage/framework/cache /var/www/html/storage/logs
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Buat symbolic link storage jika belum ada
php artisan storage:link --force || true

# Optimasi cache Laravel
echo "Mengoptimalkan cache konfigurasi dan rute..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Menjalankan PHP-FPM dan Nginx..."
php-fpm -D
exec nginx -g "daemon off;"
