# Права доступа
----------
Ролевое управление доступом - разработка политики выборочного контроля доступа,
В то время как объекты систем разрешений на объекты группируются в зависимости от их конкретного применения,
Формируя роль.

Формирование ролей предназначено для определения понятных и понятных для пользователей
Правила контроля доступа. Ролевое управление доступом позволяет гибко,
Динамически изменяясь во время работы правил систем контроля доступа.

## Пользователь

У пользователя есть несколько вариантов управления ролями

```php
// Проверяем, имеет ли пользователь права
// Проверка осуществляется как для пользователя, так и для его роли
Auth:user()->hasAccess($string);

// Получить все роли пользователя
Auth::user()->getRoles();

// Проверить имеет ли пользователь роль
Auth::user()->inRole($role)

// Добавить к пользователю роль
Auth::user()->addRole($role)
```

## Роли

Роли также имеют процедуры для:

```php
// Возвращает всех пользователей с этой ролью
$role->getUsers();
```


## Создание администратора

Чтобы создать пользователя с максимальным (в момент создания) правами
Выполните следующую команду:


```php
php artisan make:admin nickname email@email.com secretpassword
```


## Добавление собственных разрешений

Пример добавления собственных расширений с использованием поставщика

```php
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Kernel\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $permission = $this->registerPermissions();
        $dashboard->permission->registerPermissions($permission);
    }

    protected function registerPermissions()
    {
        return [
            'Modules' => [
                [
                    'slug'        => 'Analytics',
                    'description' => 'Description',
                ],
            ],

        ];
    }
}
```
