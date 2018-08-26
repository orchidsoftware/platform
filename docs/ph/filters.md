# Mga Filter
----------


Ang mga filter ay nagsisilbing tagapagpadali ng paghahanap ng mga talaan na gumagamit ng karaniwang filter.
Halimbawa, kung gusto mong i-filter ang katalogo ng mga produkto ayon sa katangian, brands, atbp.
Ang pagpili ng mga halaga ​​ay nakabase sa mga parametro ng mga kahilingang Http.

Hindi ito isang handang solusyon o unibersal na kasangkapan,
kailangan mong palawakin ang istraktura para sa iyong mga partikular na aplikasyon.

## Paglilikha

Upang makalikha ng bagong filter, may isang utos:

```php
php artisan orchid: filter QueryFilter
```

Maglilikha ito ng isang klaseng filter sa folder na `app/Http/Filters`


Halimbawa ng filter:
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

Ang filter ay gagana kapag may isa o higit pang parametro na naitakda sa hanay na `$parameters`,
Kapag ang hanay ay bakante, gagana ang filter sa bawat kahilingan.

## Paggamit

Upang magamit ang filter, kailangan mong itakda ito sa iyong paggalaw na klase.
```php
use Orchid\Entities\Many;

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

> ** Tandaan ** na pwede mong gamitin ang parehong mga filter para sa iba't-ibang mga paggalaw.


Ang pagpi-filter ay maaaring simulan gamit ang `filtersApply` na pamamaraan:
```php
use Orchid\Press\Models\Post;

Post::type ('news')->filtersApply()->simplePaginate ();
```


Upang magamit ang mga filter sa iyong mga modelo,
kailangan mong ikonekta ang trade na `Orchid\Platform\Traits\FilterTrait` at magpasa ng hanay ng mga klase sa function na ` filtersApply`:

```php
use App\MyModel;

MyModel::filtersApply ([
   Filter::class,
])->simplePaginate ();

```
