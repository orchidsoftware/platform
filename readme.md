<p align="center">
<a href="https://github.com/TheOrchid/Platform"><img width="250"  src="https://theorchid.github.io/assets/img/orchid.svg">
</a>
</p>


#

<p align="center">
<a href="https://www.paypal.me/tabuna/10usd"><img src="https://img.shields.io/badge/Donate-PayPal-green.svg"></a>
<a href="https://github.com/chiraggude/awesome-laravel#starter-projects"><img src="https://cdn.rawgit.com/sindresorhus/awesome/d7305f38d29fed78fa85652e3a63e154dd8e8829/media/badge.svg"></a>
<a href="https://styleci.io/repos/73781385"><img src="https://styleci.io/repos/73781385/shield?branch=master"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/v/stable"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/downloads"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/license"/></a>
</p>

## Official Documentation

Documentation can be found at [Orchid website](https://theorchid.github.io/en/docs/).

You can watch [live](http://demo-orchid.tk)

**Login**: admin@admin.com **Password**: password


## System requirements

Make sure your server meets the following requirements.

- Apache 2.2+ or nginx
- MySQL Server 5.7.8+ or PostgreSQL
- PHP Version 7.0+


## Install


#### Via Composer

Going your project directory on shell and run this command: 
```php
$ composer require orchid/platform
```

####  Provider and Facades

Add to `config/app.php`:

Service provider to the 'providers' array:
```php
'providers' => [
  // Laravel Framework Service Providers...
  //...

  // Package Service Providers
  Orchid\Platfrorm\Providers\FoundationServiceProvider::class,

  // ...

  // Application Service Providers
  // ...
];
```

Facades aliases to the 'aliases' array:
```php
'aliases' => [
  // ...
  'Dashboard' =>  Orchid\Platfrorm\Facades\Dashboard::class,
  'Alert' =>  Orchid\Alert\Facades\Alert::class,
  'Active' => Watson\Active\Facades\Active::class,
];
```


#### User

Inherit your model App\User

```php
namespace App;

use Orchid\Platfrorm\Core\Models\User as UserOrchid;

class User extends UserOrchid
{

}

```

#### Migration and Publish

```php
php artisan vendor:publish
php artisan notifications:table 
php artisan migrate
php artisan make:admin admin admin@admin.com password
```

#### .env

add .evn

```php
APP_INSTALL=true
```

#### finish

go http://you.app/dashboard
login : admin@admin.com
password: password


## Security

If you discover security related issues, please email  [Alexandr Chernyaev](mailto:bliz48rus@gmail.com) instead of using the issue tracker.


## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D


## Credits

- [Alexandr Chernyaev](https://github.com/tabuna)
- [All Contributors](../../contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
