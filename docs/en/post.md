# Posts
----------
The platform is shipped with CMS functionatily and it's assumed that by default all elementst that contain website data are instances of `Post` model.
This structure suits well to most of public web sites as their structure is mostly the same.
An example of similarities:
- News,
- Promotional events,
- Pages,
- Vacancies

You may think of hundreds of variations. To evade creating almost identical models and migrations the ORCHID uses the base `Post` model. It uses JSON for columns which is more useful and easier than EAV, besides it allows internationalization. 
Some of the approaches we reproduced intentionally using Laravel WordPress wchich will allow you to be more effective.

## Data acquisition
You can get an information from database with the following commands:

```php
use Orchid\Platform\Core\Models\Post;

$posts = Post::all();
```

```php
// All published posts
$posts = Post::published()->get();
$posts = Post::status('publish')->get();

// Particular post
$post = Post::find(42);

//Name of the post according to current locale
echo $post->getContent('name');

```


An ability to store data in JSON does not mean you should fill in every value for every language, eg: an information about a bar may be in English and Russian but it does'n't mean that there may be different number of free seats for different languages. Therefore there's no sense in duplicating these parameters, instead put them into `options`.


```php
// Specific post
$post = Post::find(42);

//Get all optios 
echo $post->getOptions();

//Get all locale parameters from options
echo $post->getOption('locale');

// If there's no such option or it's not specified
// you may set the second parameter that will be returned.
echo $post->getOption('countPlace',10);

```





## Inheriting single table

If you decided to create a new class for your custom message type you may return this class for all instatnes of this message type.

Definition of post behavior is based on the defined `type`.
```php
//All the objects in $videos collection will be Post instances
$videos = Post::type('video')->status('publish')->get();
```


## Taxonomies

You may access single post taxonomy, eg:

```php
$post = Post::find(42);
$taxonomy = $post->taxonomies()->first();
echo $taxonomy->taxonomy;
```

Or you may search for posts using your own taxonomy:

```php
$post = Post::taxonomy('category', 'php')->first();
```


More complex forms are also possible, for example, you may get all posts of `main` category including it's children categories:

```php
$posts  = Post::whereHas('taxonomies.term', function($query){
	$query->whereIn('slug',
	    Category::slug('main')->with('childrenTerm')
	    ->first()->childrenTerm->pluck('term.slug')
	);
})->get()
```

Remember that these post types may be less effective in selection and are brought here mostly as example.

## Categories and Taxonomy
To get categories, taxonomies or posts of particular category you may use the following methods:

```php
// all categories
$category = Taxonomy::category()->slug('uncategorized')->posts()->first();


// Only related categories and posts
$category = Taxonomy::where('taxonomy', 'category')->with('posts')->get();
$category->each(function($category) {
    echo $category->term->getContent('name');
});

// all posts from category
$category = Category::slug('uncategorized')->posts()->first();
$category->posts->each(function($post) {
    echo $post->getContent('name');
});
```


## Attachments

Attachments are files that are related to a post. These files may be of different formats and extensions.
Every extension may be called separately, for example if you need to get only pictures or documents in post.

```php
$item = Post::find(42);
$item->attachment('image')->get();
```

Definitions are set to all uploaded pictures automatically according to values set in the `config/platform` file.
To get them you may use the key noted above.
If there's no images for that definition, the source file will be returned.

```php
$image = $item->attachment('image')->fisrt();

//Returns the standard image url with required definition
$image->url('standart');
```


## Full-text search

The platform is shipped with the Scout package which acts as the abstraction for full-text search in your Eloquent model. 
Scout does not include the search "driver" itself, you must install the required solution by yourself, it may be, for example elasticsearch, algolia, sphinx or others.


To use the full text search you need to add a new method to your behavior class:

```php
/**
 * Get the indexable data array for the model.
 *
 * @param $array
 *
 * @return mixed
 */
public function toSearchableArray($array)
{
    // Customize array...

    return $array;
}
```


It will receive all different models and return the elements required for indexing.

Lets take standard “DemoPost.php” as example, it has a lot of parameters but we truly need only two of them:

- Article title
- Article content

We must return the following:

```php
/**
 * Get the indexable data array for the model.
 *
 * @param $array
 *
 * @return mixed
 */
public function toSearchableArray($array)
{
    $array['content']['en']['id'] = $array['id'];

    return $array['content']['en'];
}
```

We've returned all data in English with index.

To import it we have to perform the following command:

```php
php artisan scout:import Orchid\\Platform\\Core\\Models\\Post
```

Now we may use the search in our project:

```php
use Orchid\Platform\Core\Models\Post;
$articles = Post::search('как пропатчить kde2 под freebsd')->get();
```
