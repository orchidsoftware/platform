@component($typeForm, get_defined_vars())
    <textarea {{ $attributes }}>{{ $value ?? '' }}</textarea>
@endcomponent
