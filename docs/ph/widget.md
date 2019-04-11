# Ang Widget
----------

Ang isang widget isang instance ng klaseng Widget o namana mula rito. Ito ay isang bahagi na pangunahing ginagamit sa pagrerehistro. Ang mga widget ay kadalasang binuo bilang mga view upang makagawa ng isang komplikado pero independenteng parte ng tagagamit na interface.


Halimbawa, ang isang kalendaryong widget ay magagamit sa pag-render ng isang komplikadong interface. Ang mga widget ay nagpapahintulot sa iyo na muling gamitin ang UI na code.

## Paglilikha

Upang makalikha ng bagong widget, kailangan mong gawin ito:

```php
php artisan orchid: widget MySuperWidget
```

Sa `app/Http/Widgets` na folder, ang klase ng widget ay nilikha, katulad lang sa tagakontrol, ang widget ay maaaring magkaroon ng sarili nitong view.
Inirerekomenda na ilagay ang mga file ng widget sa subdirektoryo ng mga view.

```php
namespace App\Http\Widgets;

use Orchid\Widget\Service\Widget;

class MySuperWidget extends Widget {

    / **
     * Class constructor.
     * /
    public function __construct () {

    }

    / **
     * @return mixed
     * /
     public function handler () {
         return view ('', [
         ]);
     }

}
```


Upang irehistro ang iyong bagong widget, kailangan mong ilagay ito sa `config/widget.php`:

```php
'widgets' => [
    'NameForMySuperWidget' => App\Widgets\MySuperWidget::class
 ],
```



## Gamit


Kapag ang widget ay tinawag, ang pamamaraang `` handler `` ay default na pinapatupad.
Upang ikonekta ang isang widget, kailangan mong ipatupad ito sa code gamit ang sintaks ng Blade:
```php
@widget ('NameForMySuperWidget')
```




## AJAX na Widget

Ang mga widget ay magagamit sa pag-download ng impormasyong podgruzdki sa mga field na para sa komunikasyon.

Pagkatapos, ang katangiang `$query` ay kukuha ng isang halaga para sa paghahanap, at ` $key` para sa napiling halaga.


```php
namespace App\Http\Widgets;

use Orchid\Widget\Widget;

class AjaxWidget extends Widget
{

    / **
     * @var null
     * /
    public $query = null;

    / **
     * @var null
     * /
    public $key = null;

    / **
     * @return array
     * /
    public function handler ()
    {
        $data = [
            [
                'id' => 1,
                'text' => 'Record 1',
            ],
            [
                'id' => 2,
                'text' => 'Record 2',
            ],
            [
                'id' => 3,
                'text' => 'Record 3',
            ],
        ];


        if (! is_null ($this->key)) {
            foreach ($data as $key => $result) {

                if ($result ['id'] === intval ($this->key)) {
                    return $data [$key];
                }
            }
        }

        return $data;

    }

}

```
