<div data-controller="layouts--listener"
     data-layouts--listener-targets="{{$targets}}"
     data-layouts--listener-slug="{{$templateSlug}}"
     data-layouts--listener-async="{{$templateAsync}}"
     data-layouts--listener-method="{{$templateAsyncMethod}}"
     data-layouts--listener-url="{{ url()->current() }}"
>
    <div data-async>
        @foreach($manyForms as $formKey => $modal)
            @foreach($modal as $item)
                {!! $item ?? '' !!}
            @endforeach
        @endforeach
    </div>
</div>
