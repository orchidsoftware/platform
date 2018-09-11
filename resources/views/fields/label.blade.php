@component('platform::partials.fields.group',get_defined_vars())
    @if(isset($fieldNames))
        <p id="{{$id}}">{{$fieldNames ?? ''}}</p>
    @endif
@endcomponent