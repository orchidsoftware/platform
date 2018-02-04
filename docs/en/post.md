#Posts
----------
The platform assumes that by default any elements that contain site data are a `Post` model.

So, now you can fetch database data:

```php
use Orchid\Platform\Core\Models\Post;

$posts = Post::all();
```

```php
//All published posts
$posts = Post::published()->get();
$posts = Post::status('publish')->get();

//A specific post
$post = Post::find(42);

//The name of the record taking into account the current localization
echo $post->getContent('name');

```


### Single Table Inheritance

If you choose to create a new class for your custom post type, you can have this class be returned for all instances of that post type.

The definition of the behavior of a record is based on the specified `type`.
```php
//all objects in the $videos Collection will be instances of Post
$videos = Post::type('video')->status('publish')->get();
```


### Taxonomies

You can get taxonomies for a specific post like:

```php
$post = Post::find(42);
$taxonomy = $post->taxonomies()->first();
echo $taxonomy->taxonomy;
```

Or you can search for posts using its taxonomies:

```php
$post = Post::taxonomy('category', 'php')->first();
```

### Categories & Taxonomies

Get a category or taxonomy or load posts from a certain category. There are multiple ways
to achieve it.


```php
//all categories
$category = Taxonomy::category()->slug('uncategorized')->posts()->first();


//only all categories and posts connected with it
$category = Taxonomy::where('taxonomy', 'category')->with('posts')->get();
$category->each(function($category) {
    echo $category->getContent('name');
});

//clean and simple all posts from a category
$category = Category::slug('uncategorized')->posts()->first();
$category->posts->each(function($post) {
    echo $post->getContent('name');
});
```

### Attachment

Attachments are files that are related to a record.
These files can be of different formats and resolutions.
Each format can be called separately, for example, take only images or only documents at the record.


```php
$item = Post::find(42);
$item->attachment('image')->get();
```

The uploaded images are automatically assigned to the permissions specified in the `config/platform`.
To call them, you can use the previously specified key.
If images for this key are not found, the original file will be returned.

```php
$image = $item->attachment('image')->fisrt();

//Returns the public address of the image with the resolution set
$image->url('standart');
```
