<div data-controller="listener"
     data-listener-targets="{{$targets}}"
     data-listener-slug="{{$templateSlug}}"
     data-listener-async-enable="{{$asyncEnable}}"
     data-listener-async-route="{{$asyncRoute}}"
>
    <div data-async>
        @foreach($manyForms as $layouts)
            @foreach($layouts as $layout)
                {!! $layout ?? '' !!}
            @endforeach
        @endforeach
    </div>
</div>
