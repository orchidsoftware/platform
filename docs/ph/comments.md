# Mga Komento
----------


Ang mga komento ay kinakailangang katangian para sa ilang uri ng mga websayt.
Salamat sa kanila, ang mga tagagamit ay makakapagpahayag ng kanilang mga opinyon sa kahit aling tala,
upang suportahan o kontrahin ang mga opinyong naihayag, upang gumawa ng isang diyalogo kasama ang ibang mga tagagamit.


## Paglikha ng isang komento

Ang mga komento ay nakalakip sa mga tala ng ORCHID

```php
use Orchid\Platform\Core\Models\Comment;
use Orchid\Platform\Core\Models\Post;

//Partikular na tala
$post = Post::find (42);

//Maglikha ng komento
$comment = Comment::create ([
    'post_id' => $post->id, //number ng tala
    'user_id' => Auth::id (), //numero ng tagagamit
    'parent_id' => 0, //pinagmulang komento
    'content' => 'Ang aking mahalagang pahayag', //teksto ng komento
    'approved' => 1, //inaprobahan/hindi inaprobahan
]);

```


## Mga relasyon


```php

//Kunin lahat ng mga komento para sa isang lathala na isinumite
$comments = Comment::findByPostId (42);


$comment = Comment::find (1);

//Kumuha ng link sa isang lathala
$post = $comment->post ();

//Kumuha ng isang pinagmulang komento
$comment = $comment->original ();

//Kumuha ng mga anak na komento
$comment = $comment->replies ();

//Kunin ang may-akda ng komento
$comment = $comment->author ();

```


## Mga pagsusuri

```php
$comment = Comment::find (1);


//Suriin kung ang komento ay nailathala na
$comment->isApproved ();

//Suriin kung ang komento ay kasagutan sa isa pang komento
$comment->isReply ();

//Suriin kung ang komento ay may mga kasagutan
$comment->hasReplies ();
```
