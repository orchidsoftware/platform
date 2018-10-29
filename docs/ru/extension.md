# Расширение панели администратора
----------

ORCHID позволяет настраивать определенные аспекты системы,
чтобы лучше соответствовать вашим потребностям. 

## Маршрутизация

Приложение ORCHID может менять адрес для обращений, что бы ваши расширения могли следовать за ней, 
требуется указывать домен и префикс. Это может выглядеть так:

```php
$this->domain(config('platform.domain'))->group(function () {
    $this->group([
        'middleware' => config('platform.middleware.private'),
        'prefix'     => \Orchid\Platform\Dashboard::prefix(),
        'namespace'  => 'Orchid\Platform\Http\Controllers',
    ], function (\Illuminate\Routing\Router $router) {
    
        $router->get('/', function () {
            return view('welcome');
        });
        
    });
});
```


## Отображение

В ходе работы вам может понадобится создавать свои собственные варианты отображения `(view)`,
что бы обеспечить единый внешний вид потребуется наследование:

```php
@extends('platform::layouts.dashboard')


@section('title','title')
@section('description', 'description')

@section('content')

    <div>
        Content
    </div>

@stop
```


## Дополнительные стили и скрипты

Если вам потребуется добавить стили и скрипты глобально, на каждую страницу, то используйте:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;

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


### Модельные классы

Вполне нормальным является желание изменить поведение некоторых классов из стандартной поставки, для того, что бы ORCHID использовал ваши классы 
моделей вместо своих, необходимо заранее зарегистрировать их подмену, с помощью:

```php
Dashboard::useModel(\Orchid\Platform\Models\User::class,\App\User::class);
```

Так же можно использовать параметр конфигурации, что позволит определить все подмены сразу:

```php
Dashboard::configure([
    'models' => [
        User::class => 'MyCustomClass',
    ],
]);
```