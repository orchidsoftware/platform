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
$ composer require orchid/platform:dev-master
```

#### User

Inherit your model App\User

```php
namespace App;

use Orchid\Platform\Core\Models\User as BaseUser;

class User extends BaseUser
{

}

```

Publish vendor files

```php
php artisan vendor:publish --all
```

Run your database migration
```php
php artisan migrate
```

Make available css/js/etc files
```php
php artisan storage:link
php artisan orchid:link
```

Create your admin user
```php
php artisan make:admin admin admin@admin.com password
```


#### Finish

To view ORCHID's dashboard go to:
```php
http://your.app/dashboard
```
