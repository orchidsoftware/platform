#Idagdag ang admin na panel
----------

## Pagruruta

Ang ORCHID na aplikasyon ay makakapagbago ng address para sa mga tawag upang ang mga update mo ay makakasunod nito,
kailangan mong itakda ang isang domain at isang prefix. Maaaring magmumukha itong ganito:

```php
$this->domain (config ('platform.domain'))->group (function () {
    $this->group ([
        'middleware' => config ('platform.middleware.private'),
        'prefix' =>\Orchid\Platform\Dashboard::prefix (),
        'namespace' => 'Orchid\Platform\Http\Controllers',
    ], function (\ Illuminate\Routing\Router $router) {
    
        $router->get ('/', function () {
            return view ('welcome');
        });
        
    });
});
```


## Pagpapakita

Sa kurso ng trabaho, baka kakailanganin mong gumawa ng iyong sariling mga opsyong pang-display `(view)`,
na magbibigay ng pinag-iisang mukha ay mangangailangan ng ganitong pagmamana:

```php
@extends ('dashboard::layouts.dashboard')


@section ('titulo', 'titulo')
@section ('deskripsyon', 'deskripsyon')

@section ('nilalaman')

    <div>
        Nilalaman
    </ div>

@stop
```


## Karagdagang mga istilo at skrip

Kung kailangan mong magdagdag ng mga istilo at skrip sa pangkalahatan, bawat pahina, gamitin ang:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    / **
     * I-bootstrap ang kahit anong serbisyong pang-aplikasyon.
     *
     * @return void
     * /
    public function boot (Dashboard $dashboard)
    {
        $dashboard->registerResource ('stylesheets', 'custom.css');
        $dashboard->registerResource ('scripts', 'custom.js');
    }

    / **
     * Irehistro ang kahit anong serbisyong pang-aplikasyon.
     *
     * @return void
     * /
    public function register ()
    {
        //
    }
}
```
