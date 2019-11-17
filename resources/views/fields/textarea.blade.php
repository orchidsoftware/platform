@component($typeForm, get_defined_vars())
    <textarea @attributes($attributes)>{!! $value ?? '' !!}</textarea>
@endcomponent
