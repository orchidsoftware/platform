@component($typeForm, get_defined_vars())
    <div data-controller="fields--input"
         data-fields--input-mask="{{$mask ?? ''}}"
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
@endcomponent
