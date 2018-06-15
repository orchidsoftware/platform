# Screens
----------


Screens are the main components of user interface that are discribed by a composition hierarcy, accoording to it every element has several properties that affect it's own apparel and entity.  By changing
the layout structure and element properties you may create completeley new layouts almost in a few minutes.

A screen doesn't know where the data is from, it may be from database, API or other external sources. A screen has standard functionality of modern user interface. You may configure the screen layout and also add or delete commands. 
    Screen's apparel is defined by the `Layouts`, so everything you need to do iss to define what data is to be displayed in particular layout.

![Screens](https://orchid.software/img/scheme/screens.jpg)


## Why not CRUD?

Almost every popular extensions use CRUD for user models, and it's a good solution, but an application cannot consist of the basic functions. You probably will extend and update the generated logic. A good example showing that standard CRUD operations are not enough is an ability to "Print". ORCHID allows to create CRUD using "screens", but it's not their main purpose.


## Informational objects and screens

When using the traditional development instruments, the creation of several layouts for displaying and changing is more complicated and hard tas than creation of data tables. It's especially noticable when you follow the three level application architecture andyou need to add a lot of proxy code for level binding. Instruments for fast development make this process drastically easier and cheeper.

Screens are used in ORCHID to display and control data, and are based on preset layouts. To bind data and screen you only need to define the displayed entities or requests. 


## Creation

With ORCHID it's easier to do it, and you may create a set of screens in a few minutes.

To create a new screen you must perform the following comand:

```php
php artisan make:screen Users
```

In the `app/Http/Controllers/Screens` directory will be created the `Users` file with the following content:

```php
namespace App\Http\Controllers\Screens;

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



## Routing registration

You may register every screen with the Route's `screen` method
```php
Route::screen('/news', 'Users','platform.screens.users.list');
//or
$route->screen('/news', 'Users','platform.screens.users.list');
```




## Data

Most of data-oriented applications work with several tables, and these tables are connected to each other. It's often required to display the data fetched from different sources or linked tables.

For example in the process of displaying an order information a screen usually contains the following information about order: date, shipment address, shipment method etc. and one or more connected entries: product, amount, unit price, VATs, full price etc..

Data to be displayed is defined in the `query` method where selections and data formation must be performed.
The data is then passed in array, which keys will be available from layouts.

An example where Layouts has the control over `user` and `users` keys:

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




## Processing

Screen Commans are availadle at the screens, they allow users to perform different user scenarios.
All required control buttons are defined inside the `commandBar` method . 

For example:

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

The `Link` class is responsible for actions that must be performed after the button is pressed, in above example after the `Print` button is pressed the `print` method is called, and all the data on the screen will be available inside the Request.


```php
// The 'create' method is called upon pressing button
Link::name('New function')->method('create');

// You will be redirected to specified address upon pressing
Link::name('External link')->link('http://google.com/');

// A modal window will be prompted upon pressing (CreateUserModal),
// here the "save" method may be used
Link::name('Modal window')
->modal('CreateUserModal')
->title('Create new user')
->method('save'),
```


## Layouts

Layouts are responsible for the visual appearance of a screen.
More about them is in [Layouts](/en/docs/layouts/) section

Every layout may include another layout therefore the nesting.
For example, a screen is separated into two columns, left contains input fields and right contains lookup table and chart.
You may think of another examples of nesting.


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
        // Modal windows
        Layouts::modals([
            'Appointments' => [
                PatientFirstRows::class,
            ],
        ]),
    ];
}
```
