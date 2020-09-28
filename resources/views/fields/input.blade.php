@component($typeForm, get_defined_vars())
    <div data-controller="fields--input"
         data-fields--input-mask="{{$mask ?? ''}}"
    >
        <input {{ $attributes }}>
    </div>
@endcomponent
