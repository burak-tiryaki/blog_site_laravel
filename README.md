# Blog Site

A simple blog website with an admin panel, built using Laravel 10.

## How to set

1. `composer install`

2. Turn file name “.env.example” to “.env”

3. Create your database and enter your info into the “.env” file.

4. `php artisan key:generate`

5. If you wish, you can create an admin account for yourself in  “database/seeders/AdminSeeder.php” or just use default

    email: “burak@burak.com“ and password: “123456”.

6. `php artisan migrate --seed`
7. All set! run the server: `php artisan serve`

## Admin Login

To log in as an admin, visit the following link: http://127.0.0.1:8000/admin/login