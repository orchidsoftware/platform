#Add admin panel
----------

## Routing

The ORCHID application can change the address for calls so that your updates can follow it,
you must specify a domain and a prefix. This might look like this:

```php
$this->domain (config ('platform.domain'))->group (function () {
    $this->group ([
        'middleware' => config ('platform.middleware.private'),
        'prefix' =>\Orchid\Platform\Kernel\Dashboard::prefix (),
        'namespace' => 'Orchid\Platform\Http\Controllers',
    ], function (\ Illuminate\Routing\Router $router) {
    
        $router->get ('/', function () {
            return view ('welcome');
        });
        
    });
});
```


## Displaying

In the course of the work, you may need to create your own display options `(view)`,
that would provide a unified appearance will require inheritance:

```php
@extends ('dashboard::layouts.dashboard')


@section ('title', 'title')
@section ('description', 'description')

@section ('content')

    <div>
        Content
    </ div>

@stop
```


## Additional styles and scripts

If you need to add styles and scripts globally, per page, then use:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Kernel\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    / **
     * Bootstrap any application services.
     *
     * @return void
     * /
    public function boot (Dashboard $dashboard)
    {
        $dashboard->registerResource ('stylesheets', 'custom.css');
        $dashboard->registerResource ('scripts', 'custom.js');
    }

    / **
     * Register any application services.
     *
     * @return void
     * /
    public function register ()
    {
        //
    }
}
```
