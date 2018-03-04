@component('dashboard::partials.fields.group',get_defined_vars())
    @if(isset($fieldNames))
        <p id="{{$id}}">{{$fieldNames or ''}}</p>
    @endif
@endcomponent