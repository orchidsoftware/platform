# Установка
----------

Это руководство по началу работы поможет вам начать использовать ORCHID. Мы перечислили основные шаги, которые вам нужно выполнить, чтобы запустить проект. ORCHID основана на [Laravel Framework](http://laravel.com), 
поэтому перед тем, как поставить приступить, вы должны установить [`Laravel`](http://laravel.com).

## Создайте проект

Установите Laravel, выполнив команду Composer `create-project` в вашем терминале:
```php
$ composer create-project --prefer-dist laravel/laravel orchid
```
У вас нет Composer? Его легко установить, следуя инструкциям на странице [загрузки](https://getcomposer.org/download/).

**Не забывайте**
- Установить права «chmod -R o + w» на каталоги `storage` и `bootstrap/cache`
- Отредактировать `.env` файл


## Добавьте пакет

Перейдите в каталог проекта и выполните команду:
```php
$ composer require orchid/platform
```

> **Примечание.** Если вы устанавливали Laravel иначе, то возможно, вам придется сгенерировать ключ
используя комманду `php artisan key:generate`

## Настройте

Опубликуем настройки и вспомогательные файлы в наше приложение:
```php
php artisan vendor:publish --provider="Orchid\Platform\Providers\FoundationServiceProvider"
php artisan vendor:publish --all
```


> **Примечание.** Вам также необходимо создать новую базу данных и обновить `.env` файл с учетными данными и добавить URL-адрес вашего приложения в переменную `APP_URL`.


Применим все наши миграции, что бы собрать базу данных:
```php
php artisan migrate
```

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

## Запуск проекта

Для запуска проекта можно использовать встроенный сервер
```php
php artisan serve
```

Панель управления будет доступна по адресу 'http://localhost:8000/dashboard'

> **Примечание.** Если используемая среда выполнения настроенна на другой домен (например orchid.loc),
 то панель администратора будет не доступна, требуется указать его в файле конфигурации `config/platform.php`
 или в `.env`. Это позволяет делать доступной панель администратора на другом домене или поддомене, например `dashboard.example.com`.
