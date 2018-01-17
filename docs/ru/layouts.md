# Макеты
----------

Отображение внешнего вида элементов пользовательского интерфейса в приложении добавляет большое значение, делает приложение
проще в использовании и помогает пользователям интуитивно отображать элементы экрана для выполнения своих задач.


Разделение логики и презентации является один из принципов разработки с ORCHID.
Одним из элементов презентации являются "Layouts", это макеты которые могут отображатся как:
- Таблица (Table)
- Колонки (Column)
- Строки (Row)
- Графики и т.п.



## Таблица

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

## Строки

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


## Графики

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


> **Примечание** Документация скоро будет дополнена
