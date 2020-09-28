@component($typeForm, get_defined_vars())
    <div data-controller="fields--quill"
         data-fields--quill-toolbar="{{$toolbar}}"
         data-theme="{{$theme ?? 'inlite'}}">
        <div id="toolbar"></div>
        <div class="quill p-3 position-relative" id="quill-wrapper-{{$id}}"
             style="min-height: {{ $attributes['height'] }}">
        </div>
        <input class="d-none" {{ $attributes }}>
    </div>
@endcomponent
