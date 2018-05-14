# Menu
----------


The ORCHID includes easy to use mechanism for creation of a custom menu (navigation) using drag & drop and localization support.


## Configuration

Most of menus are displayed at the top of a website, but position may alter for different applications, a number of menus is limited and specified at `config/platform` configuration file

```php
'menu' => [
    'header'  => 'Top Menu',
    'sidebar' => 'Sidebar Menu',
    'footer'  => 'Footer Menu',
],
```

## Model
The Menu class is common model of `Eloquent`, that has all its abilities, for example to display only parent menu items with children links and location-aware, do the following:

```php
namespace Orchid\Press\Models\Menu;

$menu = Menu::where('lang', app()->getLocale()())
    ->where('parent',0)
    ->where('type', 'footer')
    ->with('children')
    ->get();
```


Available methods:

```php
//First children element
$menu = Menu::find(1)->children()->first();


//Parent element
$menu = Menu::find(1)->parent()->get();
```
