@component('dashboard::partials.fields.group',get_defined_vars())
    <div class="simplemde-wrapper" data-controller="simplemde">
        <textarea @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>{{$attributes['value']}}</textarea>
    </div>
@endcomponent
