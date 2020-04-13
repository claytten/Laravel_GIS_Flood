# Sistem Informasi Geografis Banjir
# Framework Laravel

## Image
![dashboard](https://user-images.githubusercontent.com/38114768/79122700-99760f00-7dc2-11ea-91d5-2b42676b1312.jpg)
![homepage](https://user-images.githubusercontent.com/38114768/79122723-ac88df00-7dc2-11ea-81a0-0fc30787f969.jpg)
![maps](https://user-images.githubusercontent.com/38114768/79122746-b7437400-7dc2-11ea-8c23-c78981dcd7e4.jpg)
![data](https://user-images.githubusercontent.com/38114768/79122770-c4606300-7dc2-11ea-95b3-0f70e4dcd655.jpg)

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

## Features
* `CRUD Role,Permission and Admin`
* `CRUD maps`
* `exporting data to csv`

## Notes
 * `This is my custom template login,register,role with spatie permission`

## Email and Passwords
 * `superadmin@admin.com / secret (role:superadmin)`
 * `admin@admin.com / secret (role:admin)`
 * `clerk@admin.com / secret (role:clerk)`

# Author

[Wahyu Aji Sulaiman]('https://github.com/claytten/sig_kab')
