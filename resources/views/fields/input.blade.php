@component($typeForm,get_defined_vars())
    <div data-controller="fields--input"
         data-fields--input-mask="{{$mask ?? ''}}"
    >
        <input @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
    </div>
@endcomponent