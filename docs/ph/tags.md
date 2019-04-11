# Mga tag
----------

Tag (lebel) - isang salita o parirala na kayang pag-isahin ang isang grupo ng teksto, mga imahe, atbp. sa paksa


## Gamit

Ang mga tag ay pwedeng ikonekta sa lahat ng mga nilikhang modelo gamit ang trait

```php
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Product extends Eloquent implements TaggableInterface
{
    use TaggableTrait;
}
```


Sa modelong `Post`, pumapasok ito nang naka-default, dahil dito ang mga halimbawa ay magiging para dito.

## Karagdagan

Sa seksyong ito, ipapakita namin kung paano mo pamahalaan ang iyong mga pampaksang tag.

```php
use Orchid\Press\Models\Post;

//Kunin ang entidad na bagay
$post = Post::find (1);

//Sa pamamagitan ng isang string
$post->tag ('foo, bar, baz');

//Sa pamamagitan ng isang hanay
$post->tag (['foo', 'bar', 'baz']);
```




## Pagtatangal

Tinatanggal ang isa o mas maraming mga tag ng isang bagay sa pamamagitan ng isang hanay o isang string ng pinaghihiwalay na mga entidad gamit ang tagapaghiwalay.

```php
//Kunin ang entidad na bagay
$post = post::find (1);

//Sa pamamagitan ng isang string
$post->untag ('bar, baz');

//Sa pamamagitan ng isang hanay
$post->untag (['bar', 'baz']);

//Tanggalin lahat ng mga tag
$post->untag ();
```



## Setting

Ang pamamaraang ito ay talagang katulad sa `tag ()` na pamamaraan, pero isinasama to sa `untag ()`, kaya awtomatiko nitong tinutukoy ang mga tag na idaragdag at tatanggalin. Ito ay isang napakahalagang paraan kapag nagpapatakbo ka ng isang update sa mga entidad, at hindi mo gustong magkaroon ng mga pagsusuri upang patunayan kung aling mga tag ang dapat idagdag o tanggalin.

```php
//Kunin ang entidad na bagay
$post = Post::find (1);

//Sa pamamagitan ng isang string
$post->setTags ('foo, bar, baz');

//Sa pamamagitan ng isang hanay
$post->setTags (['foo', 'bar', 'baz']);

//Gamit ang `slug` na hanay
$post->setTags (['foo', 'bar', 'baz'], 'slug');
```


## Pagbabasa

May ilan kaming mga paraan na makakatulong sa inyong kunin ang lahat ng mga tag na nakalakip sa bagay at gawin ang kabaliktaran at kunin ang lahat ng mga bagay gamit ang mga ibinigay na mga tag.

```php
//Kunin ang entidad na bagay
$post = Post::whereTag ('foo, bar')->get ();


$post = Post::find (1);
$tags = $post->tags;

$tags = Post::allTags ();
```
