<div data-controller="input"
     data-input-mask="{{$mask ?? ''}}"
     @class([
        'd-none' => $attributes['type'] === 'hidden' || $attributes['hidden']
     ])
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
