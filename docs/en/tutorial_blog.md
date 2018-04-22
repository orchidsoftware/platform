# Blog creation
----------

This document is a step-by-step guide demonstrating how to create a blog on Laravel with ORCHID. Examples are picked up to help the newcomer to handle all the problems from start to end.

## Installation

First we install the Laravel and the ORCHID package


## Layout

Let's pick the calm and clean [Clean Blog](https://github.com/BlackrockDigital/startbootstrap-clean-blog) on bootstrap for our layout.


First we install all the styles and javascript to compose them with webpack.
By default there is the sass styles directory in assets folder but our theme uses ess. 
Let's create the new directory instead of old one (You may use sass, it won't affect the main process) and copy files to js and less accordingly.


Then we install bootstrap

```php
npm install bootstrap --save
```

Require it and the theme file in app.js:
```php
require('./bootstrap');
require('clean-blog');
```

We also must import it into styles file, to do so we open clean-blog.less and add the following:

```php
// Fonts
@import url(https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;subset=cyrillic);
@import url(https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800);

@import "../../../node_modules/bootstrap/less/bootstrap";
@import "variables.less";
@import "mixins.less";
```

For the sake of standartization we rename the clean-blog.less to app.less. That's all, now we may build the application.

Let's open webpack.mix.js and add the following instruction:
```php
mix.js('resources/assets/js/app.js', 'public/js')
   .less('resources/assets/less/app.less', 'public/css');
```

Great, now all the dependencies of our blog are ready.


## Templates

Let's open the main template of our blog view/layouts/app.blade.php and change it like the following:

```php
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title','Last posts') - {{setting('site_title')}}</title>
    <meta name="description" content="{{setting('site_description')}}">
    <meta name="keywords" content="{{setting('site_keywords')}}">

    <link href="{{mix('css/app.css')}}" rel="stylesheet">
</head>



<body>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="/">{{config('app.name')}}</a>
        </div>

        @widget('menu','header')
    </div>
    <!-- /.container -->
</nav>

@yield('content')

<hr>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <p class="copyright text-muted">Copyright &copy; 2015 - {{date('Y')}}</p>
            </div>
        </div>
    </div>
</footer>

<script src="{{mix('js/app.js')}}"></script>

</body>

</html>

```


There are new features aside from standard Laravel:

- setting — the helper that allows to get values from the storage.
- widget — user view and code execution.


## Widget

Now let's create our one-level menu widget that we will be able to control from panel:

To do so execute the following command:

```php
php artisan make:widget MenuWidget
```


The artisan will create the empty widget file in `/app/Http/Widgets`. 
We wil only need to register it in the config file `config/widget.php`


```php
'widgets' => [
    'menu' => App\Http\Widgets\MenuWidget::class,
],
```

Let's change it so it will gather all the menu elements and pass them to the view:

```php
namespace App\Http\Widgets;

use Orchid\Widget\Widget;
use Orchid\Press\Models\Menu;

class MenuWidget extends Widget {

    /**
     * @return mixed
     */
    public function handler($typemenu = 'header')
    {
        $menu = Menu::where('lang', config('app.locale'))
            ->where('parent',0)
            ->where('type', $typemenu)->get();

        return view('partials.menu', [
            'menu'  => $menu,
        ]);
    }

}
```

then the view itself will look like that:

```php
<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse">
    <ul class="nav navbar-nav navbar-right">
        @foreach($menu as $item)

            <li>
                <a href="{{$item->slug}}"
                   title="{{$item->title}}"
                   target="{{$item->target}}"
                   rel="{{$item->robot}}"
                   class="{{$item->style}}"
                >
                    {{$item->label}}
                </a>
            </li>

        @endforeach
    </ul>
</div>
<!-- /.navbar-collapse -->
```


## Behavior

Great, let's display our blog posts, to do it we will use or platform's `many posts`:


```php
php artisan make:manyBehavior Blog
```

At the address `/app/Behaviors/Many` the empty `Blog.php` will be created, now let's fill it:

```php
namespace App\Behaviors\Many;

use Orchid\Press\Behaviors\Many;
use Orchid\Platform\Fields\Field;
use Orchid\Platform\Http\Forms\Posts\BasePostForm;
use Orchid\Platform\Http\Forms\Posts\UploadPostForm;
use Orchid\Platform\Platform\Fields\TD;

class Blog extends Many
{
    /**
     * @var string
     */
    public $name = 'Blog';

    /**
     * @var string
     */
    public $description = 'Blog description';

    /**
     * @var string
     */
    public $slug = 'blog';

    /**
     * Slug url /news/{name}.
     *
     * @var string
     */
    public $slugFields = 'name';

    /**
     * Rules Validation.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'id'             => 'sometimes|integer|unique:posts',
            'content.*.name' => 'required|string',
            'content.*.body' => 'required|string',
        ];
    }

    /**
     * @return array
     * @throws \Orchid\Press\Exceptions\TypeException
     */
    public function fields() : array
    {
        return [
            Field::tag('input')
                ->type('text')
                ->name('name')
                ->max(255)
                ->required()
                ->title('Article name')
                ->help('What's the name of the article?'),

            Field::tag('wysiwyg')
                ->name('body')
                ->required()
                ->rows(10),

            Field::tag('input')
                ->type('text')
                ->name('title')
                ->max(255)
                ->required()
                ->title('Page title')
                ->help('Title of the tab'),

            Field::tag('textarea')
                ->name('description')
                ->rows(5)
                ->required()
                ->title('Brief summary'),

            Field::tag('tags')
                ->name('keywords')
                ->title('Key words'),
        ];
    }

    /**
     * @return array
     */
    public function modules() : array
    {
        return [
            BasePostForm::class,
            UploadPostForm::class,
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid() : array
    {
        return [
            TD::name('name')->title('Name'),
            TD::name('publish_at')->title('Published at'),
            TD::name('created_at')->title('Created at'),
        ];
    }
}
```


After that we may register it on the platform `config/platform`

```php
/*
|--------------------------------------------------------------------------
| Many Behaviors
|--------------------------------------------------------------------------
|
*/

'many' => [
    App\Behaviors\Many\Blog::class,
],
```


After that we must grant our user the rights to redact these posts in the dashboard, 
we must go to user permissions tab and pick the required access rights.

> **Notice.** If there is no ability to grant the rigths to new post type, the configuration file cache must be reset by the command `php artisan config:clear`

After you save, the new post section will occur in the main menu. Now we may fill our blog with content.


## Data input

Our posts need to be displayed, so we create the controller with the following contents:

```php
php artisan make:controller BlogController
```

```php
namespace App\Http\Controllers;

use Orchid\Press\Models\Post;

class BlogController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::type('blog')
            ->status('publish')
            ->with('attachment')
            ->orderBy('publish_at','Desc')
            ->simplePaginate(5);
        return view('pages.main', [
            'posts' => $posts
        ]);
    }
    /**
     * @param Post $post
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Post $post)
    {
        return view('pages.post', [
            'post' => $post
        ]);
    }
}
```

After that we change the blog routing:

```php
$router->get('/','BlogController@index');

$router->get('/{blog}','BlogController@show')
    ->where('blog','^(?!dashboard).*$')
    ->name('blog.post');
```

To display the human friendly url let's add the blog route binding to RouteServiceProvider:

```php
Route::bind('blog', function ($value) {
    return Post::where('slug', $value)
        ->type('blog')
        ->with(['attachment'])
        ->firstOrFail();
});
```


Well, there's a little left to do: create views for all the data to do so we create `pages` directory with `main.blade.php` and `post.blade.php` in the `views` directory 

`post.blade.php` будет выглядеть так:
```php
@extends('layouts.app')

@section('title',$post->getContent('title'))
@section('keywords',$post->getContent('keywords'))
@section('description',$post->getContent('description'))

@section('content')



<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header" 
        style="background-image: url('{{$post->attachment->first()->url() }}')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-heading">
                    <h1>{{$post->getContent('name')}}</h1>
                    <h2 class="subheading">{{$post->getContent('subname')}}</h2>
                    <span class="meta">
                        Published {{$post->publish_at->diffForHumans()}}
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Post Content -->
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <main>
                {!! $post->getContent('body') !!}
                </main>
            </div>
        </div>
    </div>
</article>
@endsection
```

`main.blade.php` will look like:

```php
@extends('layouts.app')

@section('content')

<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header" style="background-image: url('img/home-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <h1>Universe</h1>
                    <hr class="small">
                    <span class="subheading">In simple terms about complicated things</span>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

            @foreach($posts as $post)
            <div class="post-preview">
                <a href="{{route('blog.post',$post->slug)}}">
                    <h2 class="post-title">
                        {{$post->getContent('name')}}
                    </h2>
                    <h3 class="post-subtitle">

                        {{ str_limit(strip_tags($post->getContent('body')),150) }}
                    </h3>
                </a>
                <p class="post-meta">
                    Published: {{$post->publish_at->diffForHumans()}}
                </p>
            </div>
            <hr>
            @endforeach


            <div class="row text-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
```

The new function (not present in Laravel) is provided here, the `getContent`, it returns the values we set as inputs in our dashboard.



## Source code

Finally, we created a simple blog using Laravel and ORCHID.
 The source code is available at [github](https://github.com/tabuna/SimpleBlogOrchid).
