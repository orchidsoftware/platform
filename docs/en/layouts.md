# Screen layouts
----------

Displaying the appearance of the user interface elements in the application is of great importance, makes the application
easier to use and helps users to intuitively display screen elements to perform their tasks.


Separation of logic and presentation is one of the development principles with ORCHID.
One of the elements of the presentation are "Layouts", these are layouts that can be displayed as:
- Tables
- Speakers
- Strings
- Charts
- Modal windows



## Table

The table layout is used to display the minimum information for viewing and sampling.

```php
php artisan make: table PatientListLayout
```

Example:
```php
namespace App\Layouts\Clinic\Patient;

use App\Http\Filters\LastNamePatient;
use Orchid\Platform\Http\Filters\CreatedFilter;
use Orchid\Platform\Http\Filters\SearchFilter;
use Orchid\Platform\Http\Filters\StatusFilter;
use Orchid\Platform\Layouts\Table;

class PatientListLayout extends Table
{

    / **
     * @var string
     * /
    public $data = 'patients';

    / **
     * HTTP data filters
     *
     * @return array
     * /
    public function filters (): array
    {
        return [
            LastNamePatient::class,
            SearchFilter::class,
        ];
    }

    / **
     * @return array
     * /
    public function fields (): array
    {
        return [
            'last_name' => [
                'name' => 'Last name',
                'action' => function ($patient) {
                    return '<a href = "'. route ('dashboard.clinic.patient.edit',
                            $patient->id). '">'. $patient->last_name. '</a>';
                },
            ],
            'first_name' => 'First Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'created_at' => 'Date of publication',
        ];
    }
}
```

## Lines

The row layout is the minimum set that is most often used.
Its goal is to combine all the necessary fields.

To create, execute the command:
```php
php artisan make: rows PatientFirstRows
```

Example:
```php
namespace App\Layouts\Clinic\Patient;

use App\Http\Widgets\AppointmentTypes;
use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class Appointment extends Rows
{

    / **
     * @return array
     *
     * @throws\Orchid\Platform\Exceptions\TypeException
     * /
    public function fields (): array
    {
        return [

            Field::tag ('datetime')
                ->name ('appointment_time')
                ->required ()
                ->title ('Time'),

            Field::tag ('relationship')
                ->name ('appointment_type')
                ->required ()
                ->title ('Appointment type')
                ->handler (AppointmentTypes::class),

            Field::tag ('textarea')
                ->name ('doctor_notes')
                ->rows (10)
                ->required ()
                ->title ('Doctor notes')
                ->help ('What did the patient complain about?'),

        ];
    }
}
```


## Charts

The layout of graphs is a convenient way to graphically display the dynamics of values, but it requires some
data processing, sample data from `query`

```php
/ **
 * Query data
 *
 * @param Patient $patient
 *
 * @return array
 * /
public function query ($patient = null): array
{
    $charts = [
        [
            'title' => "Some Data",
            'values' => [25, 40, 30, 35, 8, 52, 17, -4],
        ],
        [
            'title' => "Another Set",
            'values' => [25, 50, -10, 15, 18, 32, 27, 14],
        ],
        [
            'title' => "Yet Another",
            'values' => [15, 20, -3, -15, 58, 12, -17, 37],
        ],
    ];
    
    return [
        'charts' => $charts,
    ];
}
```


Example layout:
```php
namespace App\Layouts\Clinic\Patient;

use Orchid\Platform\Layouts\Chart;

class ChartsLayout extends Chart
{

    / **
     * @var string
     * /
    public $title = 'DemoCharts';

    / **
     * @var int
     * /
    public $height = 150;

    / **
     * Available options:
     * 'bar', 'line', 'scatter',
     * 'pie', 'percentage'
     *
     * @var string
     * /
    public $type = 'scatter';

    / **
     * @var array
     * /
    public $labels = [
        "12 am-3am",
        "3 am-6am",
        "6 am-9am",
        "9 am-12pm",
        "12 pm-3pm",
        "3 pm-6pm",
        "6 pm-9pm",
        "9 pm-12am",
    ];

    / **
     * @var string
     * /
    public $data = 'charts';
}
```
