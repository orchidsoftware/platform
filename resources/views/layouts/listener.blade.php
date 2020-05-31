<div data-controller="layouts--listener"
     data-layouts--listener-targets="{{$targets}}"
     data-layouts--listener-slug="{{$templateSlug}}"
     data-layouts--listener-async="{{$asyncRoute}}"
>
    <div data-async>
        @foreach($manyForms as $layouts)
            @foreach($layouts as $layout)
                {!! $layout ?? '' !!}
            @endforeach
        @endforeach
    </div>
</div>
