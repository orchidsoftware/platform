#Installation
----------

ORCHID based off [Laravel Framework](http://laravel.com), so before you put the ORCHID, you must install [`Laravel`](http://laravel.com).



#### Create-Project

Install Laravel by issuing the Composer `create-project` command in your terminal:
```php
$ composer create-project --prefer-dist laravel/laravel orchid
```

#### Require package

Going your project directory on shell and run this command: 
```php
$ composer require orchid/cms
```

#### User

Inherit your model App\User

```php
namespace App;

use Orchid\Platform\Core\Models\User as UserOrchid;

class User extends UserOrchid
{

}

```

#### Finish


**Go to url:**  localhost:8000/dashboard

The graphical installation does not work if the server is started using the `artisan serve` command, if you want to use a local server, please go to the public directory and run
```php
php -S localhost:8000
```

