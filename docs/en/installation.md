# Installation
----------

This Getting Started guide will help you start using ORCHID. We listed the basic steps that you need to perform in order to start the project. The platform is based on the [Laravel Framework](http://laravel.com),
so before you start, you must install [`Laravel`](http://laravel.com), and also make sure that your computer meets the necessary [requirements](/ docs/requirements /).

## Create Project

The platform and framework use Composer to supply and manage its dependencies.
Install the framework by running the `composer create-project` command in your terminal:

```php
$composer create-project --prefer-dist laravel/laravel orchid
```

This creates a new directory `orchid`, loads some dependencies into it, and even generates the main directories and files that you need to get started. In other words, it will install your new framework project.

> Do you have a Composer? It is easy to install by following the instructions on the [download] page (https://getcomposer.org/download/).

**Do not forget**
- Set the rights "chmod -R o + w" to the directories `storage` and` bootstrap/cache`
- Edit `.env` file


## Add package

Go to the created project directory and execute the command:
```php
$composer require orchid/platform
```

> ** Note: ** If you installed Laravel differently, then you may need to generate a key
using the `php artisan key: generate`

## Publish settings

We publish the settings and auxiliary files in our application:
```php
php artisan vendor: publish --provider = "Orchid\Platform\Providers\FoundationServiceProvider"
php artisan vendor: publish --all
```


> ** Note. ** You also need to create a new database and update the `.env` file with credentials and add the URL of your application to the variable` APP_URL`.


We will apply all our migrations to assemble the database:
```php
php artisan migrate
```

We make available custom styles, javascript scripts and other files for addressing through the address bar:
```php
php artisan storage: link
php artisan orchid: link

```


## User Model

The platform comes with a ready set of user functions, for example, access rights
It is necessary to inherit the base model in `App\Users`:

```php
namespace App;

use Orchid\Platform\Core\Models\User as BaseUser;

class User extends BaseUser
{

}

```

To create a user with the maximum rights to the current moment, you must run the command by passing
username, email address and password:
```php
php artisan make: admin admin admin@admin.com password
```

## Launch of the project

To start the project, you can use the built-in server:
```php
php artisan serve
```

Open the browser and go to `http: //localhost: 8000/dashboard`. If everything works, you will see the login page in the control panel. Later, when you are done, stop the server by pressing `Ctrl + C` in the terminal in use.

> ** Note: ** If your runtime is configured to a different domain (for example, orchid.loc),
 then the admin panel will not be available, you need to specify it in the configuration file `config/platform.php`
 or in `.env`. This allows you to make the admin panel available on another domain or subdomain, for example `dashboard.example.com`.
 
 
Having problems during installation? It is possible that someone already had this problem https://github.com/orchidsoftware/platform/issues. If not, you can send a message or ask for [help](https://github.com/orchidsoftware/platform/issues).
