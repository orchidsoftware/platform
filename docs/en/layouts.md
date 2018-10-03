# Screen layouts
----------

Displaying of the user interface appearance in application is very important, it makes an application easier to use and helps users reflexively render screen elements for tasking.


Separation of logic and presentation in one of the principles of ORCHID development. 
One of the elements of presentation is "Layouts", these are layouts displayable as:
- Tables
- Columns
- Lines
- Diagram
- Modal



## Table

Table layout is used to output minimal information for review and sampling.

```php
php artisan orchid:table PatientListLayout
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

    /**
     * @var string
     */
    public $data = 'patients';

    /**
     * HTTP data filters
     *
     * @return array
     */
    public function filters() : array
    {
        return [
            LastNamePatient::class,
            SearchFilter::class,
        ];
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            TD::name('last_name')
                ->title('Last name')
                ->setRender(function ($patient) {
                    return '<a href="' . route('platform.clinic.patient.edit',
                            $patient->id) . '">' . $patient->last_name . '</a>';
                }),

            TD::name('first_name')
                ->title('First Name'),
                
            TD::name('phone')
                ->title('Phone'),
                
            TD::name('first_name')
                ->title('First Name'),
                
            TD::name('email')
                ->title('Email'),
                
            TD::name('created_at')
                ->title('Date of publication'),
               
        ];
    }
}
```

## Lines

Lines layout has narrow set that is used most often.
Its objective to complex all the essential fields.

Use the following command for creation:
```php
php artisan orchid:rows PatientFirstRows
```

Example:
```php
namespace App\Layouts\Clinic\Patient;

use App\Http\Widgets\AppointmentTypes;
use Orchid\Screen\Field;
use Orchid\Platform\Layouts\Rows;

class Appointment extends Rows
{

    /**
     * @return array
     *
     * @throws \Orchid\Press\TypeException
     */
    public function fields(): array
    {
        return [

            Field::tag('datetime')
                ->name('appointment_time')
                ->required()
                ->title('Time'),

            Field::tag('relationship')
                ->name('appointment_type')
                ->required()
                ->title('Appointment type')
                ->handler(AppointmentTypes::class),

            Field::tag('textarea')
                ->name('doctor_notes')
                ->rows(10)
                ->required()
                ->title('Doctor notes')
                ->help('What did the patient complain about?'),

        ];
    }
}
```


## Diagrams

Diagram layout is a handy way for graphic representation of the value changes, but it requires some data processing, example of data from  `query`

```php
/**
 * Query data
 *
 * @param Patient $patient
 *
 * @return array
 */
public function query($patient = null) : array
{
    $charts = [
        [
            'title'  => "Some Data",
            'values' => [25, 40, 30, 35, 8, 52, 17, -4],
        ],
        [
            'title'  => "Another Set",
            'values' => [25, 50, -10, 15, 18, 32, 27, 14],
        ],
        [
            'title'  => "Yet Another",
            'values' => [15, 20, -3, -15, 58, 12, -17, 37],
        ],
    ];
    
    return [
        'charts' => $charts,
    ];
}
```


Layout example:
```php
namespace App\Layouts\Clinic\Patient;

use Orchid\Platform\Layouts\Chart;

class ChartsLayout extends Chart
{

    /**
     * @var string
     */
    public $title = 'DemoCharts';

    /**
     * @var int
     */
    public $height = 150;

    /**
     * Available options:
     * 'bar', 'line', 
     * 'pie', 'percentage'
     *
     * @var string
     */
    public $type = 'scatter';

    /**
     * @var array
     */
    public $labels = [
        "12am-3am",
        "3am-6am",
        "6am-9am",
        "9am-12pm",
        "12pm-3pm",
        "3pm-6pm",
        "6pm-9pm",
        "9pm-12am",
    ];

    /**
     * @var string
     */
    public $data = 'charts';
}
```
