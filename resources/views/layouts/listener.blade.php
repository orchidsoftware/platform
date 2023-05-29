<x-orchid-stream :target="$templateSlug" :rule="\request()->routeIs('platform.async.listener')">
    <div data-controller="listener"
         data-listener-targets="{{$targets}}"
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
</x-orchid-stream>
