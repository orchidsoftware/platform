# Configuration file
----------

ORCHID uses the standard Laravel configuration system.
All parameters can be found in `config` directory, and the `platform.php` file is main for platform. Every setting is prompted with commentary summing it's essence.

## Platform address

```php
'domain' => env('DASHBOARD_DOMAIN', parse_url(config('app.url'))['host']),
```

Dashboard address plays an important role for many projects .
For example, an application may be at the address `example.com` and a dashboard is at `admin.example.com` or even at external domain.

To perform this you need to define which address must be accessed to open it. 

```php
'domain' => 'admin.example.com',
```
 
Remember that your web server parameters must be properly configured.




## Platform prefix


```php
'prefix' => env('DASHBOARD_PREFIX', 'dashboard'),
```

The system installed on the website can be easily defined by the dashboard prefix, for example it is `wp-admin` for WordPress, and it gives an opportunity to automatically search for old vulnerable versions of software and gain control over it.
 
There are other reasons but we won't speak of them in this section. 
The point is that ORCHID allows to change`dashboard` prefix to every other name, `admin` or `administrator` for example.



## Middlewares

```php
'middleware' => [
    'public'  => ['web'],
    'private' => ['web', 'dashboard'],
],
```

You may add or delete middlewares of graphical interface. 
At the moment there is two types of middlewares: `public`, that unauthorized user may access to, for example, it may be `Login` page or `Password recovery`, and `private` that may be accessed only by authorized users.


You may add as much new middlewares as you want, as example the middleware for IP whitelist filtration.



## Authorization page

```php
'auth' => [
    'display' => true,
    'image'   => '/orchid/img/background.jpg',
    //'slogan'  => '',
],
```

Authorization page has several settings like background image and your project motto. 
Also there is an ability to completely disable the embedded authorization form and implement your own with the following command:

```php
php artisan orchid:auth
```



## Post localization

```php
'locales' => [
    'en' => [
        'name'     => 'English',
        'script'   => 'Latn',
        'dir'      => 'ltr',
        'native'   => 'English',
        'regional' => 'en_GB',
    ],
],
```

Generic entries created with `entity` system may be localized, it means you may create the same entries in different languages; to add new language you only need to add new element to array.


## User menu

```php
'menu' => [
    'header'  => 'Header menu',
    'sidebar' => 'Sidebar menu',
    'footer'  => 'Footer menu',
],
```

Menu configuration only requires key and value that will be shown to user. 
By default there are three types of menus: upper, side and lower. 
You may add or delete them if you need.

You may see an example of menu usage [there](/en/docs/tutorial_blog/#vidzhet).

## Dashboard resources


```php
'resource' => [
    'stylesheets' => [],
    'scripts'     => [],
],
```

During your work you may need to add your own style tables or javascript scenarios globally for all the pages, so you need to add them to relevant arrays.
