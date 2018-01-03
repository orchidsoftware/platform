# Расширение панели администратора
----------

## Меню

Меню панели - это элемент интерфейса администратора,
Позволяет выбрать один из нескольких перечисленных вариантов программного обеспечения.
Это важный элемент графического интерфейса пользователя.



### Использование:

Чтобы зарегистрировать новое меню для своего пакета или модуля, вам необходимо
указать его в поставщике композитора.
	
```php
namespace App\Http\Composers;

use Orchid\Platform\Kernel\Dashboard;

class MenuComposer
{
    /**
     * MenuComposer constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function compose()
    {
        $this->dashboard->menu->add('Main', [
            'slug'       => 'slug-my-menu',
            'icon'       => 'icon',
            'route'      => '#',
            'label'      => 'My name Menu',
            'childs'     => true,
            'main'       => true,
            'active'     => 'dashboard.mymenu.*',
            'permission' => 'dashboard.mymenu',
            'badge'      => [
                'class' => 'bg-primary',
                'data' => function(){
                    return 7;
                }
            ],
            'sort'       => 1,
        ]);
    }
}
```

Регистрация композера
```php
public function boot()
{
    View::composer('dashboard::layouts.dashboard', MenuComposer::class);
}
```


## Отображение

В ходе работы вам может понадобится создавать свои собственные варианты отображения `(view)`,
что бы обеспечить единый внешний вид потребуется наследование:

```php
@extends('dashboard::layouts.dashboard')


@section('title','title')
@section('description', 'description')

@section('content')

    <div>
        Content
    </div>

@stop
```


## Дополнительные CSS & JS

Если вам потребуется добавить стили и скрипты глобально, на каждую страницу, то используйте:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Kernel\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
        $dashboard->registerResource('stylesheets','custom.css');
        $dashboard->registerResource('scripts','custom.js');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
```
