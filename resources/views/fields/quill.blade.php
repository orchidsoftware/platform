@component($typeForm, get_defined_vars())
    <div data-controller="quill"
         data-quill-toolbar='@json($toolbar)'
         data-quill-base64='@json($base64)'
         data-quill-value='@json($value)'
         data-quill-groups="{{$attributes['groups'] ?? ''}}"
         data-theme="{{$theme ?? 'inlite'}}"
    >
        <div id="toolbar"></div>
        <div class="quill p-3 position-relative" id="quill-wrapper-{{$id}}"
             style="min-height: {{ $attributes['height'] }}">
        </div>
        <input class="d-none" {{ $attributes }}>
    </div>
@endcomponent
