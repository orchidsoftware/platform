@component($typeForm,get_defined_vars())
    <div data-controller="fields--quill" data-theme="{{$theme ?? 'inlite'}}">
        <div id="toolbar"></div>
        <div class="quill b wrapper" id="quill-wrapper-{{$id}}" style="min-height: 300px;">
        </div>
        <input type="hidden" @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
    </div>
@endcomponent