# Фильтры
----------

Фильтры служат для упрощения поиска записей с использованием типичного фильтра.
Например, если вы хотите отфильтровать каталог продуктов по атрибутам, брендам и т.п.
Выборка значений основана на параметрах Http запросов.

Это не является готовым решением или универсальным средством, 
вы должны расширить структуру для своих конкретных приложений.

## Создание

Для создания нового фильтра существует команда:

```php
php artisan orchid:filter QueryFilter
```

Это создаст класс фильтр в папке `app/Http/Filters`


Пример фильтра:
```php
namespace App\Http\Filters;

use Orchid\Platform\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class QueryFilter extends Filter
{

    /**
     * @var array
     */
    public $parameters = ['query'];

    /**
     * @var bool
     */
    public $display = true;

    /**
     * @var bool
     */
    public $dashboard = false;

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('demo', $this->request->get('query'));
    }

    /**
     * @return Field
     */
    public function display(): Field
    {
        return Input::make('query')
            ->type('text')
            ->value($this->request->get('query'))
            ->placeholder(__('Search...'))
            ->title(__('Search'));
    }
}
```

Фильтр сработает, при условии наличии хотя бы одного параметра указанного в массиве `$parameters`, 
если массив будет пуст, тогда фильтр будет работать при каждом запросе.

## Использование

Для использования фильтра, необходимо указать его в классе поведения.
```php
use Orchid\Entities\Many;

class MyBehaviorPost extends Many
{

    /**
     * HTTP data filters
     *
     * @var array
     */
    public function filters(){
        return [
            QueryFilter::class,
        ];
    }
}
```

> **Заметьте,** что вы можете использовать одни и те же фильтры для разных поведений.


Фильтрацию можно запустить методом `filtersApply`:
```php
use Orchid\Press\Models\Post;

Post::type('news')->filtersApply()->simplePaginate();
```


Для использования фильтров в собственных моделях, 
требуется подключить трейд `Orchid\Platform\Traits\FilterTrait` и передавать в функцию `filtersApply` массив классов:

```php
use App\MyModel;

MyModel::filtersApply([
   Filter::class,
])->simplePaginate();

```

## Автоматическая HTTP фильтрация и сортировка

Для реагирования на HTTP параметры, модель должна включать в себя `FilterTrait`, а так же определение доступных
атрибутов:

```php
use FilterTrait;


/**
 * @var
 */
protected $allowedFilters = [
    'id',
    'user_id',
    'type',
    'status',
    'content',
    'options',
    'slug',
    'publish_at',
    'created_at',
    'deleted_at',
];

/**
 * @var
 */
protected $allowedSorts = [
    'id',
    'user_id',
    'type',
    'status',
    'slug',
    'publish_at',
    'created_at',
    'deleted_at',
];

```

### Использование

```php
Post::filters()->defaultSort('id')->paginate();
```

Как будет реагировать фильтрация:

```php
http://example.com/demo?filter[id]=1
$model->where('id','=',1)


http://example.com/demo?filter[id]=1,2,3,4,5
$model->whereIn('id',[1,2,3,4,5]);


http://example.com/demo?filter[content.ru.name]=dwqdwq
$model->where('content->ru->name','=','dwqdwq');

```

Как будет реагировать сортировка:

```php
http://example.com/demo?sort=content.ru.name
$model->orderBy('content.ru.name','asc');

http://example.com/demo?sort=-content.ru.name
$model->orderBy('content.ru.name','desc');
```

