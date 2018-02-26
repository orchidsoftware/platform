# Platform panel menu

Platform panel menu is the dashboard element
that allows to choose from a list of provided software variants.
It's an important element of a user graphical interface because it's used to navigate the project.


To add a new element to menu we need to inform our `Dashboard` app about it,
to do so we call the method in menu properties and pass the following arguments: 
a menu element that our element will be added to (Main menu is 'Main')
and an array containing element properties. 

Âîçìîæíûå ñâîéñòâà:
```php
'slug'       => 'Unique string containing only the save symbols',
'icon'       => 'CSS code for graphical icon',
'route'      => 'Path, route() or link',
'label'      => 'Name',
'childs'     => 'Item may contain children true/false',
'main'       => 'Item is main true/false',
'active'     => 'Pages this menu must be active on /dashboard.mymenu.*',
'permission' => 'Rights user must have /dashboard.mymenu',
'sort'       => 'Element sorting 1/2/3/4',
'show'       => 'Must be shown true/false',
```


To register a new menu for your package or module you need 
to include it into your composer provider.
	

## Registration in service provider
You can register a new menu element several ways, for example, right away in `ServiceProvider`.


For example let's change `app/Providers/AppServiceProvider.php` like that:
	
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Orchid\Platform\Kernel\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
        $dashboard->menu->add('Main', [
            'slug'       => 'slug-my-menu',
            'icon'       => 'icon-anchor',
            'route'      => '#',
            'label'      => 'My menu',
            'childs'     => true,
            'main'       => true,
            //'active'     => 'dashboard.mymenu.*',
            //'permission' => 'dashboard.mymenu',
            'badge'      => [
                'class' => 'bg-primary',
                'data' => function(){
                    return 7;
                }
            ],
            'sort'       => 1,
        ]);
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
	
	
## Registration with composer	
	
Mostly you ought to register all menu items using `View::composer` to do it create a class
`app/Http/Composer/MenuComposer.php`:


	
```php
namespace App\Http\Composer;

use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Kernel\Dashboard;
use Orchid\Platform\Notifications\DashboardNotification;

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

    /**
     *
     */
    public function compose()
    {
        $this->dashboard->menu->add('Main', [
            'slug'   => 'Ñustom',
            'icon'   => 'icon-drop',
            'route'  => '#',
            'label'  => 'Ñustom',
            'childs' => true,
            'main'   => true,
            'sort'   => 6000,
        ]);

        $this->dashboard->menu->add('Ñustom', [
            'slug'      => 'Element',
            'icon'      => 'icon-user-female',
            'route'     => '#',
            'label'     => 'Element 1',
            'groupname' => 'Ñustom group',
            'divider'   => false,
            'childs'    => false,
            'sort'      => 1,
            'badge'     => [
                'class' => 'bg-dark',
                'data'  => function () {
                    return 9;
                },
            ],
        ]);

        $this->dashboard->menu->add('Ñustom', [
            'slug'    => 'Element2',
            'icon'    => 'icon-location-pin',
            'route'   => '#',
            'label'   => 'Element 2',
            'divider' => false,
            'childs'  => false,
            'sort'    => 1,
            'badge'   => [
                'class' => 'bg-primary',
                'data'  => function () {
                    return 1;
                },
            ],
        ]);

        $this->dashboard->menu->add('Ñustom', [
            'slug'    => 'Element3',
            'icon'    => 'icon-energy',
            'route'   => '#',
            'label'   => 'Element 3',
            'divider' => false,
            'badge'   => [
                'class' => 'bg-danger',
                'data'  => function () {
                    return 2;
                },
            ],
            'childs'  => false,
            'sort'    => 1,
        ]);

        $this->dashboard->menu->add('Ñustom', [
            'slug'    => 'Element4',
            'icon'    => 'icon-playlist',
            'route'   => '#',
            'label'   => 'Element 4',
            'divider' => true,
            'childs'  => false,
            'sort'    => 1,
            'badge'   => [
                'class' => 'bg-info',
                'data'  => function () {
                    return 5;
                },
            ],
        ]);

        $this->dashboard->menu->add('Ñustom', [
            'slug'      => 'Element5',
            'icon'      => 'icon-docs',
            'route'     => '#',
            'label'     => 'Element 5',
            'groupname' => 'Ñustom group',
            'divider'   => true,
            'childs'    => true,
            'sort'      => 1,
        ]);

        $this->dashboard->menu->add('Ñustom', [
            'slug'    => 'Element7',
            'icon'    => 'icon-playlist',
            'route'   => '#',
            'label'   => 'Element 7',
            'divider' => true,
            'childs'  => false,
            'sort'    => 1,
        ]);

        $this->dashboard->menu->add('Ñustom', [
            'slug'    => 'Element8',
            'icon'    => 'icon-cup',
            'route'   => '#',
            'label'   => 'Element 8',
            'divider' => true,
            'childs'  => false,
            'sort'    => 1,
        ]);

        for ($i = 1; $i < 15; $i++) {
            $this->dashboard->menu->add('Element5', [
                'slug'    => 'Element9.' . $i,
                'icon'    => 'icon-bulb',
                'route'   => '#',
                'label'   => 'Element 9.' . $i,
                'divider' => false,
                'childs'  => false,
                'sort'    => 1,
            ]);
        }
    }
}
```


Now you have to register a composer in the service provider
```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Composer\MenuComposer;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('dashboard::layouts.dashboard', MenuComposer::class);
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


## Custom menu

Menu operating principle may be boiled down to grouping the similar elements and recursive output of every group at demand (Examples are given above).

To call a menu rendering in template you may use a `Dashbord` facade passing it two arguments 
a name of group that must be displayed and a name of rendering template.

```php
{!! Dashboard::menu()->render('Main','dashboard::partials.leftMainMenu') !!}
```
