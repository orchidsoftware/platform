<p align="center">
<a href="https://github.com/TheOrchid/Platform"><img width="250"  src="https://theorchid.github.io/Platform/dist/img/orchid.svg">
</a>
</p>


#
<p align="center">
Laravel Platform application provides a very flexible and extensible way of building your custom application.
</p>

<p align="center">
<a href="https://www.codacy.com/app/a-r-t-1-s-t/Platform?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=TheOrchid/Platform&amp;utm_campaign=Badge_Grade"><img src="https://api.codacy.com/project/badge/Grade/80fc1214b05e441eba471c92fafe2c81"/></a>
<a href="https://codeclimate.com/github/TheOrchid/Platform"><img src="https://codeclimate.com/github/TheOrchid/Platform/badges/gpa.svg" /></a>
<a href="https://styleci.io/repos/73781385"><img src="https://styleci.io/repos/73781385/shield?branch=master"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/v/stable"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/downloads"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/license"/></a>
</p>



## Official Documentation

Documentation can be found at [Orchid website](https://theorchid.github.io/).



<a href="https://theorchid.github.io/docs/screenshot/" target="_blank"><img src="https://theorchid.github.io/assets/img/screen/7.png"></a>



## Installation

Orchid based off [Laravel Framework](http://laravel.com), so before you put the Orchid, you must install [Laravel](http://laravel.com).


#### Via Composer

Going your project directory on shell and run this command: 
```sh
$ composer require orchid/platform
```

####  Provider and Facades

Add to `config/app.php`:

- Service provider to the 'providers' array:
```php
'providers' => [
  // Laravel Framework Service Providers...
  //...

  // Package Service Providers
  Orchid\Providers\FoundationServiceProvider::class,

  // ...

  // Application Service Providers
  // ...
];
```

- Facades aliases to the 'aliases' array:
```php
'aliases' => [
  // ...
  'Dashboard' =>  Orchid\Facades\Dashboard::class,
  'Alert' =>  Orchid\Alert\Facades\Alert::class,
  'Setting' =>  Orchid\Settings\Facades\Setting::class,
  'Active' => Watson\Active\Facades\Active::class,
  'Image' => Intervention\Image\Facades\Image::class,
];
```


#### User

Inherit your model App\User

```php
namespace App;

use Orchid\Core\Models\User as UserOrchid;

class User extends UserOrchid
{

}

```

#### Finish


> **Go to :**  http://your-application/dashboard



## Learn More

Learn more at these links:

- [Website](https://theorchid.github.io/)
- [Documentation](https://theorchid.github.io/)
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


## Credits

- [Alexandr Chernyaev](https://github.com/tabuna)
- [Roman Pertsev](https://github.com/PertsevRoman)
- [All Contributors](../../contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
