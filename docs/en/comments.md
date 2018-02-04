# Comments
----------


Comments are required attribute for some types of websites.
Thanks to them, users can express their opinion on any record,
to support or refute the opinions expressed, to conduct a dialogue with other users.


## Creating a comment

Comments are attached to ORCHID records

```php
use Orchid\Platform\Core\Models\Comment;
use Orchid\Platform\Core\Models\Post;

//Specific record
$post = Post::find (42);

//Create Comment
$comment = Comment::create ([
    'post_id' => $post->id, //record number
    'user_id' => Auth::id (), //user number
    'parent_id' => 0, //parent comment
    'content' => 'My important statement', //comment text
    'approved' => 1, //approved/disapproved
]);

```


## Relations


```php

//Get all comments for a specific Post entry
$comments = Comment::findByPostId (42);


$comment = Comment::find (1);

//Get a link to Post
$post = $comment->post ();

//Get a parent comment
$comment = $comment->original ();

//Get child comments
$comment = $comment->replies ();

//Get the comment's author
$comment = $comment->author ();

```


## Checks

```php
$comment = Comment::find (1);


//Check if the comment is published
$comment->isApproved ();

//Check if the comment is the answer to another comment
$comment->isReply ();

//Check if the comment has answers
$comment->hasReplies ();
```
