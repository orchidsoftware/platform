# Commentaries
----------


Commentaries is the necessary attribute of some types of web-sites.
Through them users may express their thoughts about some posts, approve or disapprove opinions and have a dialog with other users.


## Creation of commentary

Commentaries are appended to ORCHID posts.

```php
use Orchid\Platform\Core\Models\Comment;
use Orchid\Platform\Core\Models\Post;

// Specific post
$post = Post::find(42);

//create commentary
$comment = Comment::create([
    'post_id'   => $post->id, // post identifier
    'user_id'   => Auth::id(), // user identifier
    'parent_id' => 0, // parent commentary
    'content'   => 'My important point of view', // commentary text
    'approved'  => 1, // approved/disapproved
]);

```


## Connections


```php

// Get all the commentaries for particular Post
$comments = Comment::findByPostId(42);


$comment = Comment::find(1);

// Get the connection to Post
$post = $comment->post();

// Get the parent commentary
$comment = $comment->original();

// Get all the children commentaries
$comment = $comment->replies();

// Get the commentary author
$comment = $comment->author();

```


## Checks

```php
$comment = Comment::find(1);


// Check if the commentary is published
$comment->isApproved();

// Check if the commentary is an answer to another commentary
$comment->isReply();

// Check if the commentary has answers
$comment->hasReplies();
```
