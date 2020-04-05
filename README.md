# Sistem Informasi Geographic Kabupaten

## Requirement
 * `PHP 7.3>`
 * `NGINX/Apache (if you run on localhost, just use php artisan serve on console)`
 * `Mysql`
 * `composer`

## Setup
* `duplicate .env-example and rename to .env`
* `Insert Identity Database`
* `composer install`
* `php aritsan key:generate`
* `php artisan migrate --seed`
* `php artisan storage:link`
* `php artisan migrate --seed`

## Notes
 * `This is my custom template login,register,role with spatie permission`

## Email and Passwords
 * `superadmin@admin.com / secret (role:superadmin)`
 * `admin@admin.com / secret (role:admin)`
 * `clerk@admin.com / secret (role:clerk)`

# Author

[Wahyu Aji Sulaiman]('https://github.com/claytten/sig_kab')