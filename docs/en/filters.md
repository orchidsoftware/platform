# Filters
----------


Filters serve to simplify the search for records using a typical filter.
For example, if you want to filter the catalog of products by attributes, brands, etc.
The selection of values ​​is based on the parameters of Http requests.

This is not a ready-made solution or a universal tool,
you must expand the structure for your specific applications.

## Creating

To create a new filter, there is a command:

```php
php artisan make: filter QueryFilter
```

This will create a class filter in the folder `app/Http/Filters`


Filter example:
```php
namespace App\Http\Filters;

use Orchid\Platform\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class QueryFilter extends Filter
{

    / **
     * @var array
     * /
    public $parameters = ['query'];

    / **
     * @var bool
     * /
    public $display = true;

    / **
     * @var bool
     * /
    public $dashboard = false;

    / **
     * @param Builder $builder
     *
     * @return Builder
     * /
    public function run (Builder $builder): Builder
    {
        return $builder->where ('demo', $this->request->get ('query'));
    }

    / **
     * @return\Illuminate\Contracts\View\Factory |\Illuminate\View\View
     * /
    public function display ()
    {
        return view ('simpleFilter', []);
    }
}
```

The filter will work if there is at least one parameter specified in the array `$parameters`,
If the array is empty, then the filter will work for each request.

## Use

To use the filter, you must specify it in the behavior class.
```php
use Orchid\Behaviors\Many;

class MyBehaviorPost extends Many
{

    / **
     * HTTP data filters
     *
     * @var array
     * /
    public $filters = [
        QueryFilter::class,
    ];
}
```

> ** Note ** that you can use the same filters for different behaviors.


Filtering can be started using the `filtersApply` method:
```php
use Orchid\Platform\Core\Models\Post;

Post::type ('news')->filtersApply()->simplePaginate ();
```


To use filters in your own models,
you need to connect the trade `Orchid\Platform\Core\Traits\FilterTrait` and pass an array of classes to the function` filtersApply`:

```php
use App\MyModel;

MyModel::filtersApply ([
   Filter::class,
])->simplePaginate ();

```
