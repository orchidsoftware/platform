@component($typeForm,get_defined_vars())
    <div>
        <input data-controller="fields--datetime" @include('platform::partials.fields.attributes', ['attributes' => $attributes]) autocomplete="off">
    </div>
@endcomponent