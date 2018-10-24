# Ang Menu
----------


Isinasama ng ORCHID ang isang madaling gamitin nga mekanismo sa paglilikha ng mga nababagong menu (nabigasyon),
gami ang drag at drop at lokalisasyon na suporta.


## Konpigurasyon

Karamihan sa mga menu ay ipinapakita sa itaas ng sayt,
pero ang lokasyon pwedeng maiiba para sa iba't-ibang mga aplikasyon,
ang bilang ng mga menu ay limitado at inilalarawan sa konpigurasyong file na `config/platform`

```php
'menu' => [
    'header' => 'Top Menu',
    'sidebar' => 'Sidebar Menu',
    'footer' => 'Footer Menu',
],
```

## Ang Modelo
Ang klaseng Menu ay ang kadalasang modelo ng `Eloquent`, lahat ng mga katangian nito ay magagamit dito,
halimbawa, maglalabas lamang ito ng pinagmulang menu na mga aytem kasama ang mga anak na link
at ang lokasyon ay mahalaga:

```php
namespace Orchid\Press\Models\Menu;

$menu = Menu::where ('lang', app()->getLocale() ())
    ->whereNull ('parent')
    ->where ('type', 'footer')
    ->with ('children')
    ->get ();
```


Ang mga pamamaraan ay magagamit:

```php
//Unang anak
$menu = Menu::find (1)->children()->first ();


//Pinagmulang Elemento
$menu = Menu::find (1)->parent()->get ();
```
