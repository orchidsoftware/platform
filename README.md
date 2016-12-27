<p align="center">
<a href="https://github.com/TheOrchid/Platform"><img width="250"  src="https://theorchid.github.io/Platform/dist/img/orchid.svg">
</a>
</p>


#
<p align="center">
Orchid Platform application provides a very flexible and extensible way of building your custom application.
</p>


[![Codacy Badge](https://api.codacy.com/project/badge/Grade/80fc1214b05e441eba471c92fafe2c81)](https://www.codacy.com/app/a-r-t-1-s-t/Platform?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=TheOrchid/Platform&amp;utm_campaign=Badge_Grade)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b21bd1a3-da88-45e3-ac22-c2b6e5f0ef0d/mini.png)](https://insight.sensiolabs.com/projects/b21bd1a3-da88-45e3-ac22-c2b6e5f0ef0d)
[![StyleCI](https://styleci.io/repos/73781385/shield?branch=master)](https://styleci.io/repos/73781385)
[![Latest Stable Version](https://poser.pugx.org/orchid/platform/v/stable)](https://packagist.org/packages/orchid/platform)
[![Total Downloads](https://poser.pugx.org/orchid/platform/downloads)](https://packagist.org/packages/orchid/platform)
[![License](https://poser.pugx.org/orchid/platform/license)](https://packagist.org/packages/orchid/platform)

![screenshot from 2016-11-15 11 34 00](https://cloud.githubusercontent.com/assets/5102591/20298551/a273bba0-ab27-11e6-850b-2fa136056453.png)



## Official Documentation

Documentation can be found at [Orchid website](https://theorchid.github.io/Platform/).


## Server Requirements
* PHP >= 7.0
* Cron
* Redis >= 3.0
* Elasticsearch >= 5.0
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Zip PHP Extension


## Installation

Orchid based off [Laravel Framework](http://laravel.com), so before you put the Orchid, you must install [Laravel](http://laravel.com).


#### Via Composer

Add the project according
```php
"require": {
    "orchid/platform": "dev-master"
}
```

####  Provider and Facades


Add the following elements in the configuration file `config/app`
```php
Orchid\Foundation\Providers\FoundationServiceProvider::class,
```

```php
'Alert' =>  Orchid\Foundation\Facades\Alert::class,
'Dashboard' =>  Orchid\Foundation\Facades\Dashboard::class,
'Setting' =>  Orchid\Foundation\Facades\Setting::class,
'Active' => Watson\Active\Facades\Active::class,
'Image' => Intervention\Image\Facades\Image::class,
```


#### Config

Change the following entry in the configuration file`config/auth.php`

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => Orchid\Dashboard\Models\User::class,
    ],
```

or inherit model App\User

```php
namespace App;

use Orchid\Foundation\Core\Models\User as UserOrchid;

class User extends UserOrchid
{

}

```


#### Publish

To publish a package in your application, use the command
```php
php artisan vendor:publish
php artisan migrate
```


#### Creating administrator


To create a user with the maximum (at time of writing) rights
run the following command:


```php
php artisan make:admin nickname email@email.com secretpassword
```


## Learn More

Learn more at these links:

- [Website](https://theorchid.github.io/Platform/)
- [Documentation](https://theorchid.github.io/Platform/)
- [Support](https://github.com/TheOrchid/Platform/issues)
- [Laravel](https://laravel.com/)

## Security

If you discover security related issues, please email bliz48rus@gmail.com instead of using the issue tracker.


## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## History

TODO: Write history

## Credits

- [Alexandr Chernyaev](https://github.com/tabuna)
- [Roman Pertsev](https://github.com/PertsevRoman)
- [All Contributors](../../contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
