# Tags
----------

A tag (mark) - is a keyword or a phrase that can thematically group text, images, etc.  


## Use

Tags can be connected to all created models by the following trait

```php
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Product extends Eloquent implements TaggableInterface
{
    use TaggableTrait;
}
```


`Post` model includes it by design, so this model is taken as an example.

## Addition

This section will show you how to manage your tag subjects.

```php
use Orchid\Platform\Core\Models\Post;

// Get the entity object
$post = Post::find(1);

// Through a string
$post->tag('foo, bar, baz');

// Through an array
$post->tag([ 'foo', 'bar', 'baz']);
```




## Deleting

Deletes one or more object tags through an array or a string of entities separated by a delimiter.

```php
// Get the entity object
$post = post::find(1);

// Through a string
$post->untag('bar, baz');

// Through an array
$post->untag(['bar', 'baz']);

// Remove all the tags
$post->untag();
```



## Settings

This method is very similar to the `tag()` method, but includes the `untag()`, so the method automatically identifies the tags for addition and deleting. That's very useful method when you run an update on entities, and you do not want to deal with checks to verify which tags should be added or deleted.

```php
// Get the entity object
$post = Post::find(1);

// Through a string
$post->setTags('foo, bar, baz');

// Through an array
$post->setTags(['foo', 'bar', 'baz']);

// Using the `slug` column
$post->setTags(['foo', 'bar', 'baz'], 'slug');
```


## Reading

We have some methods to help you get all the tags attached to the object and do the reverse and get all the objects with the given tags.

```php
// Get the entity object
$post = Post::whereTag('foo, bar')->get();


$post = Post::find(1);
$tags = $post->tags;

$tags = Post::allTags();
```
 
