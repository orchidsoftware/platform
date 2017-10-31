# Tag
----------

Tag - a word or phrase that can unite a group of text, images etc on or


### Feature:

In this section we will show how you can manage your entities tags.

```php
use Orchid\CMS\Core\Models\Post;

// Get the entity object
$post = Post::find(1);

// Through a string
$post->tag('foo, bar, baz');

// Through an array
$post->tag([ 'foo', 'bar', 'baz']);
```




### Removal:

Removes one or more tags in an array or object
through a string delimiter separated entities.

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



### Setup:

This method is very similar to the method tag (), but it combines untag (),
so that it automatically identifies the tag to add and remove.
This is a very useful method when you run an update on the subjects,
and you do not want to deal with checks to ensure that
Tags which are to be added or removed.

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


### Read:

We have some techniques to help you get all the tags,
attached to an object and do the opposite and get all objects
with predetermined tags.

```php
// Get the entity object
$post = Post::whereTag('foo, bar')->get();


$post = Post::find(1);
$tags = $post->tags;

$tags = Post::allTags();
```

