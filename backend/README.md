1. setup backend laravel

2. Clone repository dan install dependecies

- cd backend
- composer install
- cp .env.example .env

3. Konfigurasi .env

- buat file .env

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:2Pmh+WQ1rH2yZLd7FLqlXzOxfRVb6EZjvjjtlALgY9w=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=daftar_karyawan
DB_USERNAME=root
DB_PASSWORD=


4. Migrasi database dan seeder
php artisan migrate
php artisan db:seed 

5. jalankan server 
php artisan serve
