# Menu
----------


ORCHID includes an easy-to-use mechanism for creating customizable menus (navigation),
using drag & drop and localization support.


## Configuration

Most menus are displayed at the top of the site,
but the location may be different for different applications,
the number of menus is limited and defined in the configuration file `config/platform`

```php
'menu' => [
    'header' => 'Top Menu',
    'sidebar' => 'Sidebar Menu',
    'footer' => 'Footer Menu',
],
```

## Model
The Menu class is the usual model of `Eloquent`, all of its features are available to it,
for example, that would output only the parent menu items with child links
and localization is necessary:

```php
namespace Orchid\Platform\Core\Models\Menu;

$menu = Menu::where ('lang', App::getLocale ())
    ->whereNull ('parent')
    ->where ('type', 'footer')
    ->with ('children')
    ->get ();
```


Methods are available:

```php
//First child
$menu = Menu::find (1)->children()->first ();


//Parent element
$menu = Menu::find (1)->parent()->get ();
```
