# Установка
----------

ORCHID основана на [Laravel Framework](http://laravel.com), 
поэтому перед тем, как поставить ORCHID, вы должны установить [`Laravel`](http://laravel.com).

#### Создайте проект

Установите Laravel, выполнив команду Composer `create-project` в вашем терминале:
```php
$ composer create-project --prefer-dist laravel/laravel orchid
```

#### Добавьте пакет

Перейдите в каталог проекта и выполните команду:
```php
$ composer require orchid/platform
```

#### Настройте

Опубликуем настройки и вспомогательные файлы в наше приложение:
```php
php artisan vendor:publish --provider="Orchid\Platform\Providers\FoundationServiceProvider"
```

Применим все наши миграции, что бы собрать базу данных:
```php
php artisan migrate
```

Сделаем доступными css/js/etc файлы
```php
php artisan storage:link
php artisan orchid:link

```


#### Пользователь

Наследуйте свою модель `App\User`

```php
namespace App;

use Orchid\Platform\Core\Models\User as BaseUser;

class User extends BaseUser
{

}

```

#### Конец

Панель управления будет доступна по адресу 'http://www.exemple.com/dashboard'
