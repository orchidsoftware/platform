# Widget
----------

A widget is an instance of the Widget class or inherited from it. This is a component used mainly for the purpose of registration. Widgets are usually built into views to form a complex, but at the same time, independent part of the user interface.


For example, a calendar widget can be used to render a complex interface. Widgets allow you to reuse the UI code.

## Creating

To create a new widget, you must:

```php
php artisan make: widget MySuperWidget
```

In the `app/Http/Widgets` folder, the widget's class is created, just like the controller, the widget can have its own view.
It is recommended that you place the widget's files in the views subdirectory.

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


To register your new widget, you need to put it in `config/widget.php`:

```php
'widgets' => [
    'NameForMySuperWidget' => App\Widgets\MySuperWidget::class
 ],
```



## Use


When the widget is called, the `` handler '`method is executed by default.
To connect a widget, you must execute it in code using the Blade syntax:
```php
@widget ('NameForMySuperWidget')
```




## AJAX Widget

Widgets can be used to download and podgruzdki information in the fields for communication.

Then the property `$query` will take a value for searching, and` $key` the selected value.


```php
namespace App\Http\Widgets;

use Orchid\Platform\Widget\Widget;

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
