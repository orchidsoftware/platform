@component($typeForm,get_defined_vars())
    @isset($fieldNames)
        <p id="{{$id}}">{{$fieldNames ?? ''}}</p>
    @endisset
@endcomponent