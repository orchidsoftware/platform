@component($typeForm, get_defined_vars())
    <div class="simplemde-wrapper" data-controller="simplemde"
         data-simplemde-text-value='@json($attributes['value'])'>
        <textarea {{ $attributes }}></textarea>
        <input class="d-none upload" type="file" data-action="simplemde#upload">
    </div>
@endcomponent
