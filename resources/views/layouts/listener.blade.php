<x-orchid-stream :target="$templateSlug" :rule="\request()->routeIs('platform.async.listener')">
    <div data-controller="listener"
         data-listener-watched-value="{{$targets}}"
         data-listener-url-value="{{$asyncRoute}}"
         data-listener-loading-class="pe-none cursor-wait"
         id="{{$templateSlug}}"
    >
        @foreach($manyForms as $layouts)
            @foreach($layouts as $layout)
                {!! $layout ?? '' !!}
            @endforeach
        @endforeach
    </div>
</x-orchid-stream>
