@component($typeForm, get_defined_vars())
    <div class="simplemde-wrapper" data-controller="simplemde"
         data-simplemde-text-value='@json($attributes['value'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)'>
        <textarea {{ $attributes }}></textarea>
        <input class="d-none upload" type="file" data-action="simplemde#upload">
    </div>
@endcomponent
