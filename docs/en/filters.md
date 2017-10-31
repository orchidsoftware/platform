# Filters
----------

To retrieve values based on Http query parameters, you can use the command to create filters:

```php
php artisan make:filter QueryFilter
```

This will create a class filter in the folder `app/Http/Filters`


Filter example:
```php
namespace App\Http\Filters;

use Orchid\CMS\Filters\Filter;
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

The filter will work if there is at least one parameter specified in the array `$parameters`, if the array is empty, then the filter will work for each request

#### Using

To use a filter, you must specify it in the behavior class
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

Filtering can be started using the `filtersApply` method:
```php
use Orchid\CMS\Core\Models\Post;

Post::type('news')->filtersApply()->simplePaginate(10);
```
