# Installation
----------

This beginner guide will help you to start using ORCHID. We've listed up the main steps you should perform to launch the project. The platform is based on the [Laravel Framework](http://laravel.com), 
therefore first thing you shall do is install [`Laravel`](http://laravel.com) and check if your computer meets the system [requirements](/en/docs/requirements/).

## Create project

The platform and the framework use the Composer to provide and control your dependencies.   
Install the framework with the `composer create-project` command in your terminal:

```php
$ composer create-project laravel/laravel orchid-project "5.7.*" --prefer-dist
```

This will create a new folder `orchid`, download some dependencies into it and even generate main folders and files required to start your work. In other words it will install your new framework project.

> Don't have the Composer? It's easy to install it following the tutorial at [download](https://getcomposer.org/download/) page.

**Don't forget to**
- Set the «chmod -R o+w» rights for folders `storage` and `bootstrap/cache`
- Edit the `.env` file


## Add package

Go to the created project folder and execute the following command:
```php
$ composer require orchid/platform
```

> **Notice.** If you have installed the Laravel the other way you will have to generate the key
using the command `php artisan key:generate`

## Install


> **Notice.** You also need to create a new database, add the credentials to the `.env` file and add your app URL to the `APP_URL` variable.


Run process
```php
php artisan orchid:install
```


> **Notice.** Some platforms (vagrant) can not create symbolic links with this commands. And it may become necessary to manually perform the following commands 
`cp -rf vendor/orchid/platform/public public/orchid` and `mkdir -p public/storage/public`

## Create user

Run the following command to create a user with supreme (at the moment of creation) rights passing the username, e-mail and password:
```php
php artisan orchid:admin admin admin@admin.com password
```

## Run project

To run the project you may use the built-in server:
```php
php artisan serve
```

Open the browser and go to `http://localhost:8000/dashboard`. If everything works properly you will see the dashboard login page. Later, when you will end your work, stop the server with `Ctrl+C` shortcut in your terminal.

> **Notice.** If the used runtime environment is set to work on other domain, (eg: orchid.loc),
 the dashboard will not be acessible and you will have to set it in config file `config/platform.php`
 or in `.env`. This allows to make a dashboard accessible from other domains or subdomains, for example, `platform.example.com`.
 
 
Had an issue during installation? Perhaps someone has already met the same problem https://github.com/orchidsoftware/platform/issues . If not, you may send a message or request [assistance](https://github.com/orchidsoftware/platform/issues).


