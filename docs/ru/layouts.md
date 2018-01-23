# Макеты
----------

Отображение внешнего вида элементов пользовательского интерфейса в приложении добавляет большое значение, делает приложение
проще в использовании и помогает пользователям интуитивно отображать элементы экрана для выполнения своих задач.


Разделение логики и презентации является один из принципов разработки с ORCHID.
Одним из элементов презентации являются "Layouts", это макеты которые могут отображаться как:
- Таблицы
- Колонки
- Строки
- Графики
- Модальные окна



## Таблица

Макет таблицы используется для вывода минимальной информации для просмотра и выборки.

```php
php artisan make:table PatientListLayout
```

Пример:
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

## Строки

Макет строк служит минимальным набором, который чаще всего используется.
Его цель объединять все необходимые поля.

Команда создания:
```php
php artisan make:rows PatientFirstRows
```

Пример:
```php
namespace App\Layouts\Clinic\Patient;

use App\Http\Widgets\AppointmentTypes;
use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class Appointment extends Rows
{

    /**
     * @return array
     *
     * @throws \Orchid\Platform\Exceptions\TypeException
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


## Графики

Макет графиков удобный способ графически отображать динамику значений, но он требует некоторой
обработки данных, пример данных из `query`

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


Пример макета:
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
     * 'bar', 'line', 'scatter',
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
