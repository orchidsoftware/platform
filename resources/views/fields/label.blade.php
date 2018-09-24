@component($typeForm,get_defined_vars())
    @if(isset($fieldNames))
        <p id="{{$id}}">{{$fieldNames ?? ''}}</p>
    @endif
@endcomponent