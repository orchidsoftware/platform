# Create a blog
----------

This step-by-step guide demonstrates how to create a blog on Laravel using ORCHID.


## Installation

To begin, we'll install Laravel itself and the ORCHID package


### Appearance

To display our blog, take a clean and quiet topic [Clean Blog](https://github.com/BlackrockDigital/startbootstrap-clean-blog) on ​​bootstrap.


First, put all the styles and javascript scripts, in order to collect them with a webpack.
Normally, a folder for sass styles is created in the assets folder, but less is used in our topic.
Create a new directory instead of the old one (You can use sass, it does not affect the main process either) and copy the files to js and less, respectively.


Install the bootstrap itself

```php
npm install bootstrap --save
```

In the file app.js we will make its connection and the theme file:
```php
require ('./ bootstrap');
require ('clean-blog');
```

For a file with styles, we also need to connect it, for this we open clean-blog.less and add:

```php
//Fonts
@import url (https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;subset=cyrillic);
@import url (https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800);

@import "../../../node_modules/bootstrap/less/bootstrap";
@import "variables.less";
@import "mixins.less";
```

Let's rename clean-blog.less to app.less for standardization. Now we can collect the application.

Open webpack.mix.js and write the instruction:
```php
mix.js('resources/assets/js/app.js', 'public/js')
   .less('resources/assets/less/app.less', 'public/css');
```

Excellent, all the necessary dependencies of our blog are ready

### Templates

Let's open the main template of our blog view/layouts/app.blade.php and bring it to the form:

```php
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title','Последние записи') - {{setting('site_title')}}</title>
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

        @widget('menu')
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

In addition to the standard features of laravel, there are new ones:

- setting is a helper that allows you to output values from the repository.
- widget - custom view and code execution.


### Widget

Now let's create our widget of the one-level menu, so that we can manage it from the panel:

To do this, execute the command:

```php
php artisan make:widget MenuWidget
```

Artisan will create an empty widget file in `/app/Http/Widgets`.
We will only need to register it in the config file `config/widget.php`


```php
'widgets' => [
    'menu' => \App\Http\Widgets\MenuWidget::class,
],
```

Change it so that it collects all the menu items and sends them to the display:

```php
namespace App\Http\Widgets;

use Orchid\Platform\Widget\Widget;
use Orchid\Platform\Core\Models\Menu;

class MenuWidget extends Widget {

    /**
     * @return mixed
     */
    public function handler()
    {
        $menu = Menu::where('lang', config('app.locale'))
            ->whereNull('parent')
            ->where('type', 'header')->get();

        return view('partials.menu', [
            'menu'  => $menu,
        ]);
    }

}
```

Then the display itself will look like this:

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


### Behavior

Great, let's now display the records of our blog ourselves, for this we will use multiple records of the platform:

```php
php artisan make:manyBehavior Blog
```

At the address `/app/Core/Behaviors/Many`, the empty file` Blog.php` will be created, let's fill it:

```php
namespace App\Core\Behaviors\Many;

use Orchid\Platform\Behaviors\Many;
use Orchid\Platform\Http\Forms\Posts\BasePostForm;
use Orchid\Platform\Http\Forms\Posts\UploadPostForm;

class Blog extends Many
{
    /**
     * @var string
     */
    public $name = 'Записи блога';
    /**
     * @var string
     */
    public $description = 'Пример записей блога';
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
     */
    public function fields() : array
    {
        return [
            'name'        => 'tag:input|type:text|name:name|max:255|required|title:Название статьи|help:Как называется статья?',
            'body'        => 'tag:wysiwyg|name:body|max:255|required|rows:10',
            'title'       => 'tag:input|type:text|name:title|max:255|required|title:Залоголок страницы|help:Заголовок вкладки',
            'description' => 'tag:textarea|name:description|max:255|required|rows:5|title:Краткое описание',
            'keywords'    => 'tag:tags|name:keywords|max:255|required|title:Keywords|help:Ключевые слова',
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
            'name'       => 'Имя',
            'publish_at' => 'Дата публикации',
            'created_at' => 'Дата создания',
        ];
    }
}
```

After the description, you can register in the platform `config/platform`

```php
/*
|--------------------------------------------------------------------------
| Many Behaviors
|--------------------------------------------------------------------------
|
*/

'many' => [
    App\Core\Behaviors\Many\Blog::class,
],
```

After that, our user should be given the rights to edit the entries in the administration panel,
go to our user on the permissions tab and select the necessary rights.

After saving, the main menu will be the recording section. Now we can fill our blog with content.

### Outputting Data

But our records require mapping, for this we create a controller with the content:

```php
php artisan make:controller BlogController
```

```php
namespace App\Http\Controllers;

use Orchid\Platform\Core\Models\Post;

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

After this, we change the routing of our blog:

```php
$router->get('/','BlogController@index');

$router->get('/{blog}','BlogController@show')
    ->where('blog','^(?!dashboard).*$')
    ->name('blog.post');
```

To display the url address in a humanly understandable form, add the route's blog binding, to the RouteServiceProvider:

```php
Route::bind('blog', function ($value) {
    return Post::where('slug', $value)
        ->type('blog')
        ->with(['attachment'])
        ->firstOrFail();
});
```

The thing is left small, create a mapping of all this data, in the views folder, create the pages directory with `main.blade.php` and` post.blade.php`

`post.blade.php` will look like this:
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
                        Опубликовано {{$post->publish_at->diffForHumans()}}
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

`main.blade.php` will look like this:

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
                        <h1>Вселенная</h1>
                        <hr class="small">
                        <span class="subheading">Простыми словами о сложном</span>
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
                        Опубликованно: {{$post->publish_at->diffForHumans()}}
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

There is also a new function (which is not in Laravel) `getContent`, it returns the values that we specified in the control panel for writing.

### Source

Total we created a simple blog using Laravel and ORCHID.
  The source code is available at [github](https://github.com/tabuna/SimpleBlogOrchid).
