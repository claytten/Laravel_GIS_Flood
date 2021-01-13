# Sistem Informasi Geografis Banjir
## Framework Laravel 7.0

## Changelog v0.1.1
* `New UI on Admin Dashboard`
* `Upgrade Core Laravel to version 7.0`
* `Fixing issue table on data navigation`
* `Fixing error handling code 500`
* `Adding feature CRUD photos on account admin and maps dashboard`

## Image
![dashboard](https://user-images.githubusercontent.com/38114768/100688221-6cf41f00-33b4-11eb-8d04-4d2377d6da58.png)
![admin role](https://user-images.githubusercontent.com/38114768/100688255-81d0b280-33b4-11eb-863c-165d0758b6a0.png)
![update_profile](https://user-images.githubusercontent.com/38114768/100688274-914ffb80-33b4-11eb-9ace-de671718d849.png)
![homepage](https://user-images.githubusercontent.com/38114768/79122723-ac88df00-7dc2-11ea-81a0-0fc30787f969.jpg)
![maps](https://user-images.githubusercontent.com/38114768/79122746-b7437400-7dc2-11ea-8c23-c78981dcd7e4.jpg)
![data](https://user-images.githubusercontent.com/38114768/79122770-c4606300-7dc2-11ea-95b3-0f70e4dcd655.jpg)

### Requirement
 * `PHP 7.4`
 * `NGINX/Apache (if you run on localhost, just use php artisan serve on console)`
 * `Mysql`
 * `composer`

 ### Setup
* `duplicate .env-example and rename to .env`
* `Insert Identity Database`
* `composer install`
* `php artisan key:generate`
* `php artisan migrate --seed`
* `php artisan storage:link`
* `php artisan serve`

 ### Features
- \[x] System Login Admin
- \[x] CRUD Role, Admin, Map
- \[ ] Unit Testing
- \[x] CRUD maps
- \[ ] API for Mobile
- \[ ] Security API
- \[ ] Hosting

## Features
* `CRUD Role,Permission and Admin`
* `CRUD maps`
* `exporting data to csv`

## Notes
 * `This is my custom template login,register,role with spatie permission`

## Email and Passwords
 * `superadmin@admin.com / superadmin (role:superadmin)`
 * `admin@admin.com / admin (role:admin)`



# Author

[Wahyu Aji Sulaiman]('https://github.com/claytten/sig_kab')
