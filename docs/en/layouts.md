# Layouts
----------

Layouts is a layout, the best explanation is what it is:

- Table
- Columns
- Row (Row)
- Graphs, etc.



## Table

```php
php artisan make:table PatientListLayout
```

```php
namespace App\Http\Layouts\Clinic\Patient;

use Orchid\Platform\Layouts\Table;

class PatientListLayout extends Table
{

    /**
     * @var string
     */
    public $data = 'patients';

    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            'last_name'  => [
                'name'   => 'Last name',
                'action' => function ($patient) {
                    return '<a href="' . route('dashboard.clinic.patient.edit',
                            $patient->id) . '">' . $patient->last_name . '</a>';
                },
            ],
            'first_name' => 'First Name',
            'phone'      => 'Phone',
            'email'      => 'Email',
            'created_at' => 'Date of publication',
        ];
    }
}
```

## Rows

```php
php artisan make:rows PatientFirstRows
```

```php

namespace App\Http\Layouts\Clinic\Patient;

use Orchid\Platform\Layouts\Rows;

class PatientFirstRows extends Rows
{
    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            'first_name' => [
                'tag'      => 'input',
                'type'     => 'text',
                'name'     => 'patient.first_name',
                'max'      => 255,
                'required' => true,
                'title'    => 'first_name',
                'help'     => 'Article title',
            ],
            'last_name'  => [
                'tag'      => 'input',
                'type'     => 'text',
                'name'     => 'patient.last_name',
                'max'      => 255,
                'required' => true,
                'title'    => 'last_name',
                'help'     => 'Article title',
            ],
            'phone'      => [
                'tag'      => 'input',
                'type'     => 'text',
                'name'     => 'patient.phone',
                'max'      => 255,
                'required' => true,
                'title'    => 'phone',
                'help'     => 'Article title',
            ],
        ];
    }

}

```


## Chart

```php
namespace App\Http\Layout\News;

use Orchid\Platform\Layouts\Chart;

class NewsCharts extends Chart
{
    /**
     * @var int
     */
    public $height = 200;

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


#### The documentation will soon be completed
