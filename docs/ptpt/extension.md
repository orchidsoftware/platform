# Extensão do painel de instrumentos
----------

## Roteamento

O aplicativo ORCHID pode alterar o endereço da solicitação. Se tu quiseres que as tuas extensões sigam o painel, deves especificar o domínio e o prefixo. Pode parecer como isto:

ORCHID application can change request address. If you want your extensions to follow the dashboard, you should specify the domain and prefix. It may seem like this:

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


## Exibição

Durante o trabalho tu poderás precisar de criar a tua própria variação de exibição `(view)`, para fornecer uma aparência comum deves proceder da seguinte maneira:

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


## Estilos e scripts adicionais

Se precisares de adicionar lobalmente estilos e scripts em cada página, usa o seguinte:

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
