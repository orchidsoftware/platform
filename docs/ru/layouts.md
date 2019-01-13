# Макеты экрана
----------

Отображение внешнего вида элементов пользовательского интерфейса в приложении играет большое значение, делает приложение
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
php artisan orchid:table PatientListLayout
```

Пример:
```php
namespace App\Layouts\Clinic\Patient;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

use Orchid\Platform\Http\Filters\SearchFilter;
use App\Http\Filters\LastNamePatient;

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
            TD::set('last_name','Last name')
                ->align('center')
                ->width('100px')
                ->setRender(function ($patient) {
                    return '<a href="' . route('platform.clinic.patient.edit',
                            $patient->id) . '">' . $patient->last_name . '</a>';
                }),

            TD::name('first_name')
                ->title('First Name')
                ->sort()
                ->link('platform.clinic.patient.edit', 'id'),
                
            TD::set('phone','Phone')
                ->loadModalAsync('oneAsyncModal', 'savePhone', 'id', 'phone'),
                
            TD::set('email','Email'),
                
            TD::set('created_at','Date of publication'),
               
        ];
    }
}
```
### Доступные методы


#### align()

Метод `align()` горизонтальное выравнивание текста, принимает значения: 'left', 'center', 'right'

#### link()

Метод `link($route,$key)` добавляет в ячейку ссылку, например на редактирование данной записи.

#### linkPost()

Метод `linkPost($text)` добавляет в ячейку ссылку на текущий пост (используется в списке постов).

#### locale()

Метод `locale()` отображение данных столбца согласно текущему языку локали.

#### loadModalAsync()

Метод `loadModalAsync($modal, $method, $options, $text)` добавляет модальное окно к каждой ячейке столбца. Где атрибуты $modal - название модального окна, $method - метод (функция) который отправляет данные через POST запрос, $options дополнителиные атрибуты, например id или slug, $text - отображаемое значение ячейки.

#### name()

Метод `name($key)` устанавливает имя ключа из массива значения которого отображать в таблице.

#### set()

Метод `set($key, $name)` основной метод устанавливает имя ключа из массива и отображаемое название. Заменяет методы `name()` и `title()`.

#### setRender()

Метод `setRender(function ($item) { return $item->id})` возможность генерации ячейки согласно функции. В $item передаются данные текущей строки.

#### sort()

Метод `sort()` добавляет в заголовок возможность сортировки по данному столбцу.

#### title()

Метод `title($name)` устанавливает заголовок столбца.

#### width()

Метод `width()` явно задает ширину столбца `width('100px')`



## Строки

Макет строк служит минимальным набором, который чаще всего используется.
Его цель объединять все необходимые поля.

Для создания исполните команду:
```php
php artisan orchid:rows PatientFirstRows
```

Пример:
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
     * @throws \Orchid\Press\EntityTypeException
     */
    public function fields(): array
    {
        return [

            DateTimerField::make()
                ->name('appointment_time')
                ->required()
                ->title('Time'),

            RelationshipField::make()
                ->name('appointment_type')
                ->required()
                ->title('Appointment type')
                ->handler(AppointmentTypes::class),

            TextAreaField::make()
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
