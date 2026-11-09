# URL filters and sorting

Use `Filterable` with `AllowedFilters` and `AllowedSorts` to declare which model
columns may be filtered or sorted through URL parameters.

```php
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\AllowedFilters;
use Orchid\Filters\AllowedSorts;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDate;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Filters\Types\WhereIn;
use Orchid\Filters\Types\WhereMaxMin;

#[AllowedFilters([
    'id'         => Where::class,
    'user_id'    => WhereIn::class,
    'rating'     => WhereMaxMin::class,
    'content'    => Like::class,
    'publish_at' => WhereDate::class,
    'created_at' => WhereDateStartEnd::class,
    'deleted_at' => WhereDateStartEnd::class,
])]
#[AllowedSorts([
    'id',
    'user_id',
    'rating',
    'publish_at',
    'created_at',
    'deleted_at',
])]
class Post extends Model
{
    use Filterable;
}
```

Apply the URL parameters when building the query:

```php
$posts = Post::filters()->defaultSort('id', 'desc')->paginate();
```

For example:

```text
?filter[id]=42
?filter[user_id]=1,2
?filter[content]=Laravel&sort=-created_at
?filter[rating][min]=3&filter[rating][max]=5
```

Prefix a sort column with `-` for descending order. Undeclared filter and sort
columns are ignored. The attributes govern URL input; an explicit query such as
`orderBy()` or `defaultSort()` remains under application control.

## Inheritance

Filters and sorts are inherited independently from the nearest ancestor that
declares the corresponding attribute. A child declaration replaces that entire
list. Lists are never automatically merged, so a restricted child model cannot
accidentally regain columns allowed by its parent.

For example, a child of Orchid's User can disable URL filtering and allow sorting
only by name:

```php
use Orchid\Filters\AllowedFilters;
use Orchid\Filters\AllowedSorts;
use Orchid\Platform\Models\User;

#[AllowedFilters([])]
#[AllowedSorts(['name'])]
class RestrictedUser extends User {}
```

An explicit empty array disables the corresponding inherited list. Omitting an
attribute preserves its inherited declaration. If neither the class nor its
ancestors declares an attribute, its list is empty.

Generated User models inherit the package User's attributes. Declare attributes
on the application model only when its lists need to differ.

## Migrating existing models

This replaces the `$allowedFilters` and `$allowedSorts` properties. Those
properties are no longer read by `Filterable`.

Move the contents of each property to the corresponding class attribute and
remove the property. Keep the column names and filter classes unchanged.

Migrate child models that previously overrode either property as well. Otherwise
they inherit the parent's attribute instead of their old property override.
If an override previously used an empty array, declare `#[AllowedFilters([])]` or
`#[AllowedSorts([])]` explicitly.

The query methods and URL parameter syntax remain unchanged.
