
<h1 align="center">
  <br>
  <a href="https://orchid.software/"><img src="https://orchid.software/img/orchid.svg" alt="ORCHID" width="250"></a>
  <br>
  <br>
</h1>

<h4 align="center">Powerful platform for building a business application using the  <a href="https://laravel.com" target="_blank">Laravel</a> framework.</h4>

<p align="center">
<a href="https://travis-ci.org/TheOrchid/Platform/"><img src="https://travis-ci.org/TheOrchid/Platform.svg?branch=master"></a>
<a href="https://styleci.io/repos/73781385"><img src="https://styleci.io/repos/73781385/shield?branch=master"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/v/stable"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/downloads"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/license"/></a>
</p>

![screenshot](https://user-images.githubusercontent.com/5102591/32980416-22ad653e-cc77-11e7-9fb9-4747b241270f.png)

## Introduction

ORCHID is a package for the Laravel framework, which simplifies the development of web sites and line-of-business applications. The focus is on rapid prototyping and content customization.

The platform is provided as a package, you can easily integrate it as a third-party component using Composer


## Official Documentation

Documentation can be found at [Orchid website](http://orchid.software).

You can watch [live](http://demo.orchid.software)

**Login**: admin@admin.com **Password**: password



## Some frequently asked questions for you

 **What is ORCHID?**
 
ORCHID is a package for Laravel which helps with the administration of the application on Laravel, allowing you to write code as you want, control of routing/themes/plugins/etc - none of this and will not be! The package only gives a good set of tools that will be in demand in almost every project.
                   
**Is it necessary to use the built-in recordings?**

We assume that most of your records will be stored in json, which will allow you to do the translation and the universal structure, but if the rails have goals like a CRM system with harsh conditions, then of course you can use the classic CRUD yourself, orchids will not stop you.
    
**Are there any additional system requirements from Laravel?**

Yes, you need a PHP extension for image processing and support for json type your database.

**How much does it cost?**

ORCHID is free, but we appreciate donations.


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
