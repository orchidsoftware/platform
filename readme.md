<p align="center">
<a href="https://github.com/TheOrchid/Platform"><img width="250"  src="https://orchid.software/img/orchid.svg">
</a>
</p>


#

<p align="center">
<a href="https://travis-ci.org/TheOrchid/Platform/"><img src="https://travis-ci.org/TheOrchid/Platform.svg?branch=master"></a>
<a href="https://styleci.io/repos/73781385"><img src="https://styleci.io/repos/73781385/shield?branch=master"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/v/stable"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/downloads"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/license"/></a>
</p>



## Introduction

ORCHID is a package for the Laravel framework, which simplifies the development of web sites and line-of-business applications. The focus is on rapid prototyping and content customization.

The platform is provided as a package, you can easily integrate it as a third-party component using Composer

## Official Documentation

Documentation can be found at [Orchid website](http://orchid.software).

## Online Demo
You can view a demo at [http://demo.orchid.software](http://demo.orchid.software)

**Email**: admin@admin.com

**Password**: password


## System requirements

Make sure your server meets the following requirements.

- Apache 2.2+ or nginx
- MySQL Server 5.7.8+ or PostgreSQL
- PHP Version 7.0+


## Installation

Firstly, download the Laravel installer using Composer:
```php
$ composer require orchid/platform:dev-master
```

Extend your user model using the `Orchid\Core\Models\User as BaseUser` alias:

```php
namespace App;

use Orchid\Platform\Core\Models\User as BaseUser;

class User extends BaseUser
{

}

```

Publish ORCHID's vendor files

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


#### Usage

To view ORCHID's dashboard go to:
```php
http://your.app/dashboard
```
and use
**Email**: admin@admin.com
**Password**: password


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
