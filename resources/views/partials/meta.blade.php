@foreach($SeoMetaTags['title'] as $name => $content)
    <title>{{$content}}</title>
@endforeach

@foreach($SeoMetaTags['meta'] as $name => $content)
    <meta name="{{$name}}" content="{{$content}}">
@endforeach

@foreach($SeoMetaTags['og'] as $name => $content)
    <meta property="og:{{$name}}" content="{{$content}}">
@endforeach
