# Screen
----------

Screen is the application screen for displaying data. He does not know where the data comes from, it can be: a database, OData channels, API or any other external sources. The screen has the usual functionality of a modern user interface. You can customize the appearance of the screen, and add or remove commands.
    Building the appearance is based on the provided layouts (Layouts) and all you need to do is just to determine what data will be displayed in a particular template.



## Why not CRUD?

Almost all popular add-ins use the construction of CRUD for custom models, this is a good solution, but the application can not consist of basic functions alone. Most likely you will expand and supplement the generated logic. A good example is that the standard operations for creating / reading / editing / deleting are not enough can be the ability to "Send to print." ORCHID allows you to create a CRUD using the "Screens", but this is not their goal.


### Information objects and screens

ORCHID simplifies the development of business applications through the active use of Laravel and screens.

Screens (or forms) are used in the ORCHID to display data. Screens are based on predefined templates. To link the data to the screen, you only need to specify the displayed entities or queries.


### Creating

To create a new screen, you need to execute the command:

```php
php artisan make:screen Users
```

In the `app/Http/Screens` directory, the` Users` file will be created with the following content:

```php
namespace App\Http\Screens;

use Illuminate\Http\Request;
use Orchid\Platform\Screen\Screen;

class Users extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'Users Screen';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'Users Screen';

    /**
     * Query data
     *
     * @return array
     */
    public function query() : array
    {
        return [];
    }

    /**
     * Button commands
     *
     * @return array
     */
    public function commandBar() : array
    {
        return [];
    }

    /**
     * Views
     *
     * @return array
     */
    public function layout() : array
    {
        return [];
    }
}

```

### Data

The data to be displayed on the screen is determined in the `query` method, where samples or information should be generated.
The transfer is carried out in the form of an array, the keys will be available in the layouts, to manage them.

```php
    /**
     * Query data
     *
     * @return array
     */
    public function query() : array
    {
        return [
            'user'  => User::find(1),
            'users' => User::paginate(),
        ];
    }
```


### Treatment

The screens provide built-in commands (Screen Command Bar), allowing users to perform various methods.
For this, the `commandBar` method, in which the required control buttons are described, responds. For example:

```php
/**
* Button commands
*
* @return array
*/
public function commandBar() : array
{
return [
    Link::name('Print')->method('print'),
];
}
```

Link responds to what will happen by clicking on the button, in the example above, when you click the 'Print' button,
the screen method `print` will be called, all the data that the user saw on the screen will be available in the Request.

```php
// Upon clicking, the 'create'
Link::name('New function')->method('create');

// By clicking you will be redirected to the specified address
Link::name('Link')->link('http://google.com/');

// On pressing it will show the modal window (CreateUserModal),
// in which you can execute the "save"
Link::name('Modal windows')
->modal('CreateUserModal')
->title('New User')
->method('save'),
```


### Layouts

Layouts are responsible for the appearance of the screen, that is, how and in what form the data will be displayed.
For more information, see [Layouts](/en/docs/layouts/).

Each layout can include another layout, that is, nesting.
For example, the screen is divided into two columns, in the left margin for filling, on the right is a reference table and a graph.
You can come up with your own examples of attachments.


```php
/**
 * Views
 *
 * @return array
 */
public function layout() : array
{
    return [
        Layouts::columns([
            'Left column' => [
                PatientFirstRows::class,
            ],
            'Right column' => [
                PatientSecondRows::class,
            ],
        ]),
        Layouts::columns([
            'Left column' => [
                AppointmentListLayout::class
            ],
            'Right column' => [
                InvoiceListLayout::class
            ],
        ]),
        // Modals dialog
        Layouts::modals([
            'Appointments' => [
                PatientFirstRows::class,
            ],
        ]),
    ];
}
```

### Registration in routes

You can register each screen using the `screen` method from Route
```php
Route :: screen ('/ news', 'NewsList', 'dashboard.screens.news.list');
// or
$ route-> screen ('/ news', 'NewsList', 'dashboard.screens.news.list');
```



#### The documentation will soon be completed
