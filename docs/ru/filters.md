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
php artisan make:filter QueryFilter
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function display()
    {
        return view('simpleFilter',[]);
    }
}
```

Фильтр сработает, при условии наличии хотя бы одного параметра указанного в массиве `$parameters`, 
если массив будет пуст, тогда фильтр будет работать при каждом запросе.

## Использование

Для использования фильтра, необходимо указать его в классе поведения.
```php
use Orchid\Behaviors\Many;

class MyBehaviorPost extends Many
{

    /**
     * HTTP data filters
     *
     * @var array
     */
    public $filters = [
        QueryFilter::class,
    ];
}
```

> **Заметьте,** что вы можете использовать одни и те же фильтры для разных поведений.


Фильтрацию можно запустить методом `filtersApply`:
```php
use Orchid\Platform\Core\Models\Post;

Post::type('news')->filtersApply()->simplePaginate();
```


Для использования фильтров в собственных моделях, 
требуется подключить трейд `Orchid\Platform\Core\Traits\FilterTrait` и передавать в функцию `filtersApply` массив классов:

```php
use App\MyModel;

MyModel::filtersApply([
   Filter::class,
])->simplePaginate();

```
