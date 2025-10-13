<div data-controller="input"
     data-input-mask="{{$mask ?? ''}}"
     @if ($attributes['hidden'])
     style="display: none;"
     @endif
>
    <input {{ $attributes }}>
</div>

@empty(!$datalist)
    <datalist id="datalist-{{$name}}">
        @foreach($datalist as $item)
            <option value="{{ $item }}">
        @endforeach
    </datalist>
@endempty
