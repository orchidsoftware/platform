
<h1 align="center">
  <br>
  <a href="https://orchid.software/"><img src="https://orchid.software/img/orchid.svg" alt="ORCHID" width="250"></a>
  <br>
  <br>
</h1>

<h4 align="center">Building a business application using the  <a href="https://laravel.com" target="_blank">Laravel</a> framework.</h4>

<p align="center">
<a href="https://travis-ci.org/orchidsoftware/platform/"><img src="https://travis-ci.org/orchidsoftware/platform.svg?branch=develop"></a>
<a href="https://styleci.io/repos/73781385"><img src="https://styleci.io/repos/73781385/shield?branch=master"/></a>
<a href="https://codecov.io/gh/orchidsoftware/platform"><img src="https://codecov.io/gh/orchidsoftware/platform/branch/develop/graph/badge.svg" /></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/v/stable"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/downloads"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/license"/></a>
<a href="https://t.me/orchid_community"><img src="https://img.shields.io/badge/chat-telegram-blue.svg"/></a>
</p>

## Introduction

Platform gives you a simpler and faster way to create professional-quality business applications for Laravel framework.  
Using application templates, saves the time and effort of building from scratch, without sacrificing the flexibility needed to create custom applications.

## Official Documentation

Documentation can be found at [ORCHID website](http://orchid.software).

###### Simple screenshot:
![screenshot](https://user-images.githubusercontent.com/5102591/46505838-08bc8b80-c83b-11e8-965a-0c215cb75952.png)

## Installation

Firstly, download the Laravel installer using Composer:
```php
$ composer require orchid/platform
```

Install package

```php
php artisan orchid:install
```

Create your admin user
```php
php artisan orchid:admin admin admin@admin.com password
```

Once these commands have completed, you are ready to enjoy platform!

## Change log

See [CHANGELOG](CHANGELOG.md).


## Test

```bash
php vendor/bin/phpunit --coverage-html ./logs/coverage ./tests
```

## Donate & Support

If you would like to support development by making a donation you can do so [here](https://www.paypal.me/tabuna/10usd). &#x1F60A;


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

---

> [orchid.software](https://orchid.software) &nbsp;&middot;&nbsp;
> GitHub [@tabuna](https://github.com/tabuna) &nbsp;&middot;&nbsp;
> Twitter [@orchid_platform](https://twitter.com/orchid_platform)
