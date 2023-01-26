<div data-controller="listener"
     data-listener-targets="{{$targets}}"
     data-listener-extra-vars="{{$extraVars}}"
     id="{{$templateSlug}}"
     data-listener-async-route="{{$asyncRoute}}"

     {{--
          data-listener-slug="{{$templateSlug}}"
     data-listener-async-enable="{{$asyncEnable}}"
     --}}
>
        @foreach($manyForms as $layouts)
            @foreach($layouts as $layout)
                {!! $layout ?? '' !!}
            @endforeach
        @endforeach
</div>
