# Widget
----------

Widget - an instance of Widget, or inherited from him.
This component is used mainly for the purpose of registration.
Widgets are usually embedded in the representation to form a complex but at the same time independent of the user interface.


For example, a calendar widget can be used to render complex calendar interface.
Widgets allow you to reuse the user interface code.

### Creature :
	
To create a new widget, you need to	
```php
php artisan make:widget MySuperWidget
```

The `app/Http/Widgets` folder to create a class of the widget template like a controller, a widget can also have its own view.

Recommended sitting widget files in a subdirectory views.
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

To register your new widget, you must bring it to the `config/widget.php`
```php
'widgets' => [
    'NameForMySuperWidget' => App\Widgets\MySuperWidget::class
 ],
```
	


###Using :


"Run" method is executed when the call widget default.
you must perform in the code to connect the widget using Blade syntax:
```php
@widget('NameForMySuperWidget')
```
