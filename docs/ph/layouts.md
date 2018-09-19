# Mga Layout ng Screen
----------

Ang pagpapakita sa mukha ng mga elemento ng tagagamit na interface sa aplikasyon ay talagang napakahalaga, ginagawa nito ang aplikasyon
na mas madaling gamitin at tumutulong sa mga tagagamit na maiging ipakita ang mga elementong pang-screen upang gawin ang kanilang mga gawain.


Ang paghihiwalay sa lohika at presentasyon ay isa sa mga prinsipyo ng pagbubuo gamit ang ORCHID.
Isa sa mga elemento ng presentasyon ay ang mga "Layout", ito ang mga layout na maipapakita bilang:
- Mga Talahanayan
- Mga Speaker
- Mga String
- Mga Tsart
- Mga modal na window



## Talahanayan

Ang talahanayang layout ay ginagamit sa paglalahad ng pinakamaliit na impormasyon para sa pagpapakita at pagkukuha ng sample.

```php
php artisan orchid: table PatientListLayout
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
                    return '<a href = "'. route ('platform.clinic.patient.edit',
                            $patient->id). '">'. $patient->last_name. '</a>';
                },
            ],
            'first_name' => 'Unang Pangalan',
            'phone' => 'Telepono',
            'email' => 'Email',
            'created_at' => 'Petsa ng Paglathala',
        ];
    }
}
```

## Mga Linya

Ang hanay na layout ay ang pinakamaliit na grupo na kadalasang ginagamit.
Ang layunin nito ay pag-isahin ang lahat ng mahahalagang mga field.

Upang maglikha, paganahin ang sumusunod na utos:
```php
php artisan orchid: rows PatientFirstRows
```

Halimbawa:
```php
namespace App\Layouts\Clinic\Patient;

use App\Http\Widgets\AppointmentTypes;
use Orchid\Screen\Field;
use Orchid\Platform\Layouts\Rows;

class Appointment extends Rows
{

    / **
     * @return array
     *
     * @throws\Orchid\Press\TypeException
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


## Mga Tsart

Ang layout ng mga grap ay isang madaling paraan sa grapikal na paglahad ng dinamiks ng mga halaga, pero nangangailangan ito ng ilang mga
pagpo-proseso ng datos, halimbawang datos mula sa `query`

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


Halimbawang layout:
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
     * Magagamit na mga opsyon:
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
