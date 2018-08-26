# Paglilikha ng isang blog
----------

Ang hakbang-hakbang na gabay na ito ay naglalahad kung paano gumawa ng isang blog sa Laravel gamit ang ORCHID.


## Instalasyon

Upang makapagsimula, i-install natin ang Laravel at ang pakete ng ORCHID


### Hitsura

Upang ipakita ang ating blog, kumuha ng isang malinis at tahimik na paksang [Malinis na Blog](https://github.com/BlackrockDigital/startbootstrap-clean-blog) sa ​​bootstrap.


Una, ilagay lahat ng mga istilo at javascript na mga skrip, upang makolekta sila gamit ang webpack.
Karaniwan, ang isang folder para sa mga istilong sass ay nilikha sa folder ng mga asset, pero kaunti lang ang ginamit sa ating paksa.
Lumikha ng bagong direktoryo sa halip na luma (Magagamit mo ang sass, hindi rin nito naapektuhan ang pangunahing proseso) at kopyahin ang mga file sa js at kaunti pa.


I-install ang bootstrap

```php
npm install bootstrap --save
```

Sa file na app.js, gagawin natin ang isang koneksyon at pantemang file:
```php
require ('./ bootstrap');
require ('clean-blog');
```

Para sa isang file na may mga istilo, kailangan rin nating ikonekta ito, para dito bubuksan natin ang clean-blog.less at idagdag ang:

```php
//Fonts
@import url (https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;subset=cyrillic);
@import url (https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800);

@import "../../../node_modules/bootstrap/less/bootstrap";
@import "variables.less";
@import "mixins.less";
```

Papalitan natin ng pangalan ang clean-blog.less ng app.less para sa istandardisasyon. Ngayon pwede na nating pag-isahin ang aplikasyon.

Buksan ang webpack.mix.js at isulat ang sumusunod na mga instruksyon:
```php
mix.js('resources/assets/js/app.js', 'public/js')
   .less('resources/assets/less/app.less', 'public/css');
```

Magaling, ang lahat ng mga kinakailangang dependency ng ating blog ay handa na

### Mga Template

Buksan natin ang pangunahing template ng ating blog na view/layouts/app.blade.php at dalhin ito sa form:

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

<!-- Nabigasyon -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <!-- Ang Brand at toggle ay ginugrupo para sa mas magandang pang-mobile na display -->
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

Bilang karagdagan sa mga istandard na katangian ng laravel, may mga bagong katangian:

- ang setting ay isang katulong na tumutulong magpalabas ng mga halaga mula sa repositori.
- ang widget - karaniwang view at pagpapatupad ng code.


### Ang Widget

Ngayon, lumikha tayo ng ating widget ng isahang antas na menu, upang mapamahalaan natin ito mula sa panel:

Upang gawin ito, paganahin ang sumusunod na utos:

```php
php artisan orchid:widget MenuWidget
```

Ang artisan ay gagawa ng isang bakanteng widget na file sa `/app/Http/Widgets`.
Kailangan lang nating irehistro ito sa config na file na `config/widget.php`


```php
'widgets' => [
    'menu' => \App\Http\Widgets\MenuWidget::class,
],
```

Baguhin mo ito upang kokolektahin nito ang lahat ng mga aytem ng menu at ipadala ang mga ito sa display:

```php
namespace App\Http\Widgets;

use Orchid\Widget\Widget;
use Orchid\Press\Models\Menu;

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

Pagkatapos, ang display ay magmumukhang ganito:

```php
<!-- Kolektahin ang mga nav na link, form, at ibang mga nilalaman para sa pagto-toggle -->
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


### Paggalaw

Magaling, ngayon ipapakita natin ang mga tala ng ating mga blog, dito gagamit tayo ng maraming mga tala ng plataporma:

```php
php artisan orchid:manyBehavior Blog
```

Sa address na `/app/Core/Entities/Many`, ang bakanteng file na `Blog.php` ay malilikha, punaan natin ito:

```php
namespace Orchid\Press\Entities\Many;

use Orchid\Press\Entities\Many;
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
     * Grid na View para sa post na uri.
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

Pagkatapos ng deskripsyon, makakarehistro ka sa plataporma na `config/platform`

```php
/*
|--------------------------------------------------------------------------
| Maraming mga Paggalaw
|--------------------------------------------------------------------------
|
*/

'many' => [
    Orchid\Press\Entities\Many\Blog::class,
],
```

Pagkatapos niyan, ang ating tagagamit ay dapat bigyan ng karapatang baguhin ang mga isinumite sa pang-administrasyong panel,
pumunta sa ating tagagamit sa tab ng mga pahintulot at piliin ang mga mahahalagang karapatan.

Pagkatapos i-seyb, ang pangunahing menu ay magiging ang pagtatalang seksyon. Ngayon pwede na nating punuin ang ating blog ng mga nilalaman.

### Pagpapalabas ng datos

Ang ating mga tala ay nangangailangan ng pagma-map, dahil dito lilikha tayo ng tagakontrol na may nilalamang:

```php
php artisan orchid:controller BlogController
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

Pagkatapos nito, babaguhin natin ang pagruruta ng ating blog:

```php
$router->get('/','BlogController@index');

$router->get('/{blog}','BlogController@show')
    ->where('blog','^(?!dashboard).*$')
    ->name('blog.post');
```

Upang ipakita anng url na address sa anyong maiintindihan ng tao, idagdag ang blog binding ng ruta, sa RouteServiceProvider:

```php
Route::bind('blog', function ($value) {
    return Post::where('slug', $value)
        ->type('blog')
        ->with(['attachment'])
        ->firstOrFail();
});
```

Ang bagay ay napabayaang maliit, lumikha ng pagma-map ng lahat ng mga datos na ito, sa folder ng mga view, lumikha ng direktoryo ng mga pahina gamit ang `main.blade.php` at `post.blade.php`

Ang `post.blade.php` ay magmumukhang ganito:
```php
@extends('layouts.app')

@section('title',$post->getContent('title'))
@section('keywords',$post->getContent('keywords'))
@section('description',$post->getContent('description'))

@section('content')



<!-- Page Header -->
<!-- Itakda ang iyong pang-background na imahe para sa header na ito sa linya sa ibaba. -->
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

Ang `main.blade.php` ay magmumukhang ganito:

```php
@extends('layouts.app')

@section('content')


    <!-- Page Header -->
    <!-- Itakda ang iyong pang-background na imahe para sa header na ito sa linya sa ibaba. -->
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

May isang bagong function din (hindi sa Laravel) na `getContent`, ibinabalik nito ang mga halaga na itinakda natin sa control panel para sa pagsusulat.

### Pinagmulan

Bilang pagtatapos, nakalikha tayo ng isang simpleng blog gamit ang Laravel at ORCHID.
  Ang pinagmulang code ay makikita sa [github](https://github.com/tabuna/SimpleBlogOrchid).
