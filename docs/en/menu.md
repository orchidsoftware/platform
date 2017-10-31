
# Menu
----------

The system has a drag & drop menu that boosts localization.

The number of menus is limited and is defined in the configuration file `config/cms`
```php
'menu' => [
    'header'  => 'Top Menu',
    'sidebar' => 'Sidebar Menu',
    'footer'  => 'Footer Menu',
],
```


To use the data it generates, you need:

```php
namespace Orchid\CMS\Core\Models\Menu;

$menu = Menu::where('lang', App::getLocale())
    ->whereNull('parent')
    ->where('type', 'footer')
    ->with('children')
    ->get();
```

We will only take the main menu items and affiliate links.

Methods available:

```php
//Первый дочерний элемент
$menu = Menu::find(1)->children()->first();


//Родительский элемент
$menu = Menu::find(1)->parent()->get();
```
