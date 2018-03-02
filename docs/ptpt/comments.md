# Comentários
----------


Comentários é um atributo necessário para alguns tipos de sites.
Através deles, os utilizadores podem expressar os seus pensamentos sobre algumas das postagens, aprovar ou desaprovar opiniões e dialogar com outros utilizadores.


## Criação de comentários

Os comentários são anexados às postagens do ORCHID.

```php
use Orchid\Platform\Core\Models\Comment;
use Orchid\Platform\Core\Models\Post;

// postagem específica
$post = Post::find(42);

// criar comentários
$comment = Comment::create([
    'post_id'   => $post->id, // post identifier
    'user_id'   => Auth::id(), // user identifier
    'parent_id' => 0, // parent commentary
    'content'   => 'My important point of view', // commentary text
    'approved'  => 1, // approved/disapproved
]);

```


## Relações


```php

// Obtem todos os comentários para o Post específico
$comments = Comment::findByPostId(42);


$comment = Comment::find(1);

// Obtem a conexão com o Post
$post = $comment->post();

// Obtem o comentário dos pais
$comment = $comment->original();

// Obtem todos os comentários das crianças
$comment = $comment->replies();

// Obter o autor do comentário
$comment = $comment->author();

```


## Verificações

```php
$comment = Comment::find(1);


// Verifica se o comentário é publicado
$comment->isApproved();

// Verifica se o comentário é uma resposta para outro comentário
$comment->isReply();

// Verifica se o comentário tem respostas
$comment->hasReplies();
```
