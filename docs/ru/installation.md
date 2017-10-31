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
$ composer require orchid/cms
```

#### Пользователь

Наследуйте свою модель `App\User`

```php
namespace App;

use Orchid\Platform\Core\Models\User as UserOrchid;

class User extends UserOrchid
{

}

```

#### Конец


 **Перейти к URL-адресу:**  localhost:8000/dashboard

Графическая установка не работает, если сервер запускается с помощью команды `artisan serve`, если вы хотите использовать локальный сервер, перейдите в общий каталог (public) и запустите
```php
php -S localhost:8000
```
