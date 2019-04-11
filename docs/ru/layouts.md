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
     * @return array
     */
    public function fields() : array
    {
        return [
            TD::set('last_name','Last name')
                ->align('center')
                ->width('100px')
                ->render(function ($patient) {
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

- Метод `align()` горизонтальное выравнивание текста, принимает значения: 'left', 'center', 'right'

- Метод `link($route,$key)` добавляет в ячейку ссылку, например на редактирование данной записи.

- Метод `linkPost($text)` добавляет в ячейку ссылку на текущий пост (используется в списке постов).

- Метод `locale()` отображение данных столбца согласно текущему языку локали.

- Метод `loadModalAsync($modal, $method, $options, $text)` добавляет модальное окно к каждой ячейке столбца. Где атрибуты $modal - название модального окна, $method - метод (функция) который отправляет данные через POST запрос, $options дополнителиные атрибуты, например id или slug, $text - отображаемое значение ячейки.

- Метод `name($key)` устанавливает имя ключа из массива значения которого отображать в таблице.

- Метод `set($key, $name)` основной метод устанавливает имя ключа из массива и отображаемое название. Заменяет методы `name()` и `title()`.

- Метод `render(function ($item) { return $item->id})` возможность генерации ячейки согласно функции. В $item передаются данные текущей строки.

- Метод `sort()` добавляет в заголовок возможность сортировки по данному столбцу.

- Метод `title($name)` устанавливает заголовок столбца.

- Метод `width()` явно задает ширину столбца `width('100px')`


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

            DateTimer::make()
                ->name('appointment_time')
                ->required()
                ->title('Time'),

            Relationship::make()
                ->name('appointment_type')
                ->required()
                ->title('Appointment type')
                ->handler(AppointmentTypes::class),

            TextArea::make()
                ->name('doctor_notes')
                ->rows(10)
                ->required()
                ->title('Doctor notes')
                ->help('What did the patient complain about?'),

        ];
    }
}
```

Строки поддерживают короткую запись без создания отдельного класса,
например, когда требуется показать одно - два поля

```php
/**
 * Views.
 *
 * @return array
 * @throws \Throwable
 */
public function layout(): array
{
    return [
        Layouts::rows([
           Input::make('example')
                ->type('text')
                ->title('Example')
        ]),
    ];
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

Для создания исполните команду:
```php
php artisan orchid:chart ChartsLayout
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


## Набор фильтров

Для группировки фильтров, их спроса и применения, существует отдельный слой `Selection`,
в котором они указываются. 

Для создания исполните команду:
```php
php artisan orchid:selection MySelection
```

Пример класса:
```php
namespace App\Orchid\Layouts;

use Orchid\Platform\Filters\Filter;
use Orchid\Press\Http\Filters\CreatedFilter;
use Orchid\Press\Http\Filters\SearchFilter;
use Orchid\Screen\Layouts\Selection;

class MySelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
          SearchFilter::class,
          CreatedFilter::class
        ];
    }
}
```


## Табы

Табы поддерживают короткий синтаксис через вызов статического метода, 
что не требует создания отдельного класса:

```php
/**
 * Views.
 *
 * @return array
 * @throws \Throwable
 */
public function layout(): array
{
    return [
        Layouts::tabs([
            'Example Tab Table' => TableExample::class,
            'Example Tab Rows'  => RowExample::class,
        ]),
    ];
}
```

Название вкладок будет соответствовать ключам массива


## Столбцы

Аналогично табам:

```php
/**
 * Views.
 *
 * @return array
 * @throws \Throwable
 */
public function layout(): array
{
    return [
        Layouts::columns([
           TableExample::class,
           RowExample::class,
        ]),
    ];
}
```


## Раскрывающийся список


```php
/**
 * Views.
 *
 * @return array
 * @throws \Throwable
 */
public function layout(): array
{
    return [
        Layouts::collapse([
            Input::make('name')
                ->type('text')
                ->title('Name Articles')
        ])->label('More'),
    ];
}
```


## Пользовательский шаблон


В полне ожидаемая ситуация, когда необходимо отобразить собственный шаблон, 
для этого:

```php
/**
 * Views.
 *
 * @return array
 * @throws \Throwable
 */
public function layout(): array
{
    return [
        Layouts::view('myTemplate'),
    ];
}
```

Все данные из метода `query` будут переданы в ваш шаблон.
