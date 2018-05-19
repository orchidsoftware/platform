@component('platform::partials.fields.group',get_defined_vars())
    <div class="simplemde-wrapper" data-controller="fields--simplemde">
        <textarea @include('platform::partials.fields.attributes', ['attributes' => $attributes])>{{$attributes['value']}}</textarea>
    </div>
@endcomponent
