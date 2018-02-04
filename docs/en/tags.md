# Tags
----------

Tag (label) - a word or phrase that can combine a group of text, images, etc. on the topic


## Use

Tags can be connected to all created models, using the trait

```php
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Product extends Eloquent implements TaggableInterface
{
    use TaggableTrait;
}
```


In the model `Post`, it enters by default, for this the examples will be on it.

## Addition

In this section, we show how you can manage your subject tags.

```php
use Orchid\Platform\Core\Models\Post;

//Get the entity object
$post = Post::find (1);

//Through a string
$post->tag ('foo, bar, baz');

//Through an array
$post->tag (['foo', 'bar', 'baz']);
```




## Removing

Deletes one or more tags of an object through an array or through a string of separated entities by a separator.

```php
//Get the entity object
$post = post::find (1);

//Through a string
$post->untag ('bar, baz');

//Through an array
$post->untag (['bar', 'baz']);

//Remove all the tags
$post->untag ();
```



## Setting

This method is very similar to the `tag ()` method, but it combines `untag ()`, so it automatically identifies the tags to add and remove. This is a very useful method when you run an update on entities, and you do not want to deal with checks to verify which tags should be added or deleted.

```php
//Get the entity object
$post = Post::find (1);

//Through a string
$post->setTags ('foo, bar, baz');

//Through an array
$post->setTags (['foo', 'bar', 'baz']);

//Using the `slug` column
$post->setTags (['foo', 'bar', 'baz'], 'slug');
```


## Reading

We have some methods to help you get all the tags attached to the object and do the reverse and get all the objects with the given tags.

```php
//Get the entity object
$post = Post::whereTag ('foo, bar')->get ();


$post = Post::find (1);
$tags = $post->tags;

$tags = Post::allTags ();
```
