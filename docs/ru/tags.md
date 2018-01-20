# Теги
----------

Тег (метка) — слово или фраза которая может объединять группу текста, изображений и т.п по теме 


## Использование

Теги можно подключать ко всем созданным моделям, с помощью трейта

```php
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Product extends Eloquent implements TaggableInterface
{
    use TaggableTrait;
}
```


В модель `Post`, он входит по умолчанию, по этому примеры будут на нём.

## Добавление

В этом разделе мы покажем, как вы можете управлять своими субъектами тегов.

```php
use Orchid\Platform\Core\Models\Post;

// Get the entity object
$post = Post::find(1);

// Through a string
$post->tag('foo, bar, baz');

// Through an array
$post->tag([ 'foo', 'bar', 'baz']);
```




## Удаление

Удаляет один или несколько тегов объекта через массив или через строку разделенных сущности разделителем.

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



## Настройка

Этот метод очень похож на метод `tag()`, но он сочетает в себе `untag()`, так что он автоматически идентифицирует теги для добавления и удаления. Это очень полезный метод при запуске обновления на субъектов, и вы не хотите иметь дело с проверками, чтобы проверить, какие теги должны быть добавлены или удалены.

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


## Чтение

У нас есть некоторые методы, чтобы помочь вам получить все теги, прикрепленные к объекту и делать обратное и получить все объекты с заданными тегами.

```php
// Get the entity object
$post = Post::whereTag('foo, bar')->get();


$post = Post::find(1);
$tags = $post->tags;

$tags = Post::allTags();
```

