# Создание блога
----------

Этот документ является учебным пошаговом руководством в котором демонстрируется процесс создания блога на Laravel с помощью ORCHID. Примеры специально подобраны для того, что бы помочь новичку справляться с задачами от начала до конца.

## Установка

Для начало установим сам Laravel и пакет ORCHID


## Внешний вид

Для отображения нашего блога, возьмём чистую и спокойную тему [Clean Blog](https://github.com/BlackrockDigital/startbootstrap-clean-blog) на bootstrap.


Сначала поставим все стили и javascript скрипты, для того, что бы собрать их webpack’ом.
Стандартно в папке assets создана директория для sass стилей, но в нашей теме используются less. 
Создадим новую директории вместо старой (Можно использовать sass, это ни как не повлияет на основной процесс) и скопируем файлы в js и less соответственно.


Установим сам bootstrap

```php
npm install bootstrap --save
```

В файле app.js сделаем его подключение и файла темы:
```php
require('./bootstrap');
require('clean-blog');
```

Для файла со стилями мы так же должны его подключить, для этого открываем clean-blog.less и добавим:

```php
// Fonts
@import url(https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;subset=cyrillic);
@import url(https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800);

@import "../../../node_modules/bootstrap/less/bootstrap";
@import "variables.less";
@import "mixins.less";
```

Переименуем clean-blog.less в app.less для стандартизации. Всё, теперь мы можем собирать приложение.

Откроем webpack.mix.js и напишем инструкцию:
```php
mix.js('resources/assets/js/app.js', 'public/js')
   .less('resources/assets/less/app.less', 'public/css');
```

Отлично, всё необходимые зависимости нашего блога готовы.


## Шаблоны

Откроем главный шаблон нашего блога view/layouts/app.blade.php и приведём его к виду :

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


Помимо стандартных возможностей laravel, тут присутствуют новые:

- setting — хелпер который позволяет выводить значения из хранилища.
- widget — пользовательское представление и выполнение кода.


## Виджет

Теперь давайте создадим наш виджет одноуровнего меню, для того, что бы мы могли управлять им из панели:

Для этого выполним команду:

```php
php artisan make:widget MenuWidget
```


Artisan создаст пустой файл виджета в `/app/Http/Widgets`. 
Нам останется только зарегистрировать его в конфиге `config/widget.php`


```php
'widgets' => [
    'menu' => \App\Http\Widgets\MenuWidget::class,
],
```

Изменим его, что бы он собирал все элементы меню и передавал их на отображение:

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

Тогда само отображение будет выглядеть так:

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


## Поведение

Отлично, давайте теперь выводить сами записи нашего блога, для этого воспользуемся множественными записями платформы:


```php
php artisan make:manyBehavior Blog
```

По адресу `/app/Core/Behaviors/Many`, будет создан пустой файл `Blog.php`, давайте наполним его :

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


После описания можно регистрировать в платформе `config/platform`

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


После этого нашему пользователю необходимо дать права на редактирование данных записей в панели администрирования, 
перейдём к нашему пользователю на вкладку разрешений и выберем необходимые права.

После сохранения в главном меню будет раздел записи. Теперь мы можем наполнять наш блог контентом.


## Вывод данных

Но наши записи требуют отображения, для этого создадим контроллер c содержанием:

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

После этого изменим роутинг нашего блога:

```php
$router->get('/','BlogController@index');

$router->get('/{blog}','BlogController@show')
    ->where('blog','^(?!dashboard).*$')
    ->name('blog.post');
```

Для отображения url адреса в человеко понятном виде добавим биндинг роута blog, в RouteServiceProvider:

```php
Route::bind('blog', function ($value) {
    return Post::where('slug', $value)
        ->type('blog')
        ->with(['attachment'])
        ->firstOrFail();
});
```


Дело осталось за малым, создать отображение всех этих данных, в папке views создадим директорию pages с `main.blade.php` и `post.blade.php`

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

`main.blade.php` будет выглядеть так:

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

Тут тоже есть новая функция (Которой нет в Laravel) `getContent`, она возвращает значения которые мы указали в панели управления для записи.



## Исходный код

Итого мы создали простой блог с использованием Laravel и ORCHID.
 Исходный код доступен на [github](https://github.com/tabuna/SimpleBlogOrchid).
