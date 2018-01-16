# Установка
----------

ORCHID основана на [Laravel Framework](http://laravel.com), 
поэтому перед тем, как поставить ORCHID, вы должны установить [`Laravel`](http://laravel.com).

## Создайте проект

Установите Laravel, выполнив команду Composer `create-project` в вашем терминале:
```php
$ composer create-project --prefer-dist laravel/laravel orchid
```

## Добавьте пакет

Перейдите в каталог проекта и выполните команду:
```php
$ composer require orchid/platform
```

## Настройте

Опубликуем настройки и вспомогательные файлы в наше приложение:
```php
php artisan vendor:publish --provider="Orchid\Platform\Providers\FoundationServiceProvider"
php artisan vendor:publish --all
```

Применим все наши миграции, что бы собрать базу данных:
```php
php artisan migrate
```

> **Примечание.** Вам также необходимо обновить `.env` файл с учетными данными вашей базы данных.

Сделаем доступными css/js/etc файлы
```php
php artisan storage:link
php artisan orchid:link

```


## Пользователь

Наследуйте свою модель `App\User`

```php
namespace App;

use Orchid\Platform\Core\Models\User as BaseUser;

class User extends BaseUser
{

}

```

Создайте пользователя администратора
```php
php artisan make:admin admin admin@admin.com password
```

## Конец

Для запуска проекта можно использовать встроенный сервер
```php
php artisan serve
```

Панель управления будет доступна по адресу 'http://localhost:8000/dashboard'

Заметьте, если используется среда выполнения настроенная на другой домен (например orchid.loc),
 то панель администратора будет не доступна, требуется указать его в файле конфигурации `config/platform.php`
 или в `.env`. Это позволяет выносить панель администратора на другой домен или поддомен, например `dashboard.example.com`.
