# Admin panel extension
----------


## Menu

The panel menu is an element of the admin interface,
Allows you to select one of several listed software options.
It is an important element of the graphical user interface.

The menu in ORCHID is divided into several areas, which in turn can be
Containers for another menu.



### Using:

To register a new menu for your package or module, you need to
Specify it in the composer provider.
	
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

Register Composer
```php
public function boot()
{
    View::composer('dashboard::layouts.dashboard', MenuComposer::class);
}
```



# Views

In the course of the work, you may need to create your own `view`,
that would provide a unified appearance will require inheritance:

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



# Additional CSS and JS

If you need to add styles and scripts globally, per page, then use:

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

