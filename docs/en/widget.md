# Widget
----------

Widget is an instance of Widget ot it's inherited class. It's the component that is mostly used for design purposes. Widgets are usually embedded into views to form some kind of both complex and independent part of user interface.


For example, a calendar wiidget may be used in rendering a complex interface. Widgets allow to reuse the user interface code.

## Creation
	
To create a new widget you need to do the following:

```php
php artisan make:widget MySuperWidget
```

In the `app/Http/Widgets` folder a widget template class will be created. Widget may have it's own view like a controller.
It's recommended to place widget files in the views subdirectory.

```php
namespace App\Http\Widgets;

use Orchid\Widget\Service\Widget;

class MySuperWidget extends Widget {

    /**
     * Class constructor.
     */
    public function __construct(){

    }

    /**
     * @return mixed
     */
     public function handler(){
         return view('',[
         ]);
     }

}
```


To register your new widget you need to put it inside the `config/widget.php` file:

```php
'widgets' => [
    'NameForMySuperWidget' => App\Widgets\MySuperWidget::class
 ],
```
	


## Using a widget


When widget is called the  `"handler"` method is executed by default.
To connect a widget you need to perform the following operations using Blade syntax:
```php
@widget('NameForMySuperWidget')
```

## Variables

If you need to pass the variable from layout to widget you have to use an extra parameter that may be of string or array type.
```php
@widget('NameForMySuperWidget', $arguments)
```
and handle it inside the `"handler"` method of widget class.
```php
public function handler($arguments = null){
  dump($arguments);
  return view('mysuperwidget',[
            'arguments'  => $arguments,
         ]);
}
```

## AJAX Widget

Widgets may be used to upload information inside the connection fields.

Then the `$query` property will take a search value and the `$key` key will get the selected value.


```php
namespace App\Http\Widgets;

use Orchid\Widget\Widget;

class AjaxWidget extends Widget
{

    /**
     * @var null
     */
    public $query = null;

    /**
     * @var null
     */
    public $key = null;

    /**
     * @return array
     */
    public function handler()
    {
        $data = [
            [
                'id'   => 1,
                'text' => 'Post 1',
            ],
            [
                'id'   => 2,
                'text' => 'Post 2',
            ],
            [
                'id'   => 3,
                'text' => 'Post  3',
            ],
        ];


        if(!is_null($this->key)) {
            foreach ($data as $key => $result) {

                if ($result['id'] === intval($this->key)) {
                    return $data[$key];
                }
            }
        }

        return $data;

    }

}

```
