# Filters
----------


Filters serve for simplifying entries search using common filter.
For example, if you wish to filter product catalog by attributes, brands, etc.
Value sampling is based in the parameters of http requests.

This is neither box solution nor universal tool, so you should extend structure for your specific applications.

## Creation

There is a command to create a new filter:

```php
php artisan orchid:filter QueryFilter
```

It will create filter class at the folder `app/Http/Filters`


Filter example:
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
        return InputField::make('query')
            ->type('text')
            ->value($this->request->get('query'))
            ->placeholder(__('Search...'))
            ->title(__('Search'));
    }
}
```

A filter will work subject to availability of at least one of the parameters specified at an array `$parameters`, if an array is empty, then the filter will work at every request.

## Use

To use a filter you need to specify it at a entity class.
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

> **Note** that you can use same filters for different entities.


Filtration can be started by the method `filtersApply`:
```php
use Orchid\Press\Models\Post;

Post::type('news')->filtersApply()->simplePaginate();
```


To use the filters at your own models, it is necessary to apply `Orchid\Platform\Traits\FilterTrait` trade and pass to function `filtersApply` array of classes:

```php
use App\MyModel;

MyModel::filtersApply([
   Filter::class,
])->simplePaginate();

```
