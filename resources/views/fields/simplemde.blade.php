@component($typeForm, get_defined_vars())
    <div class="simplemde-wrapper" data-controller="fields--simplemde">
        <textarea {{ $attributes }}>{{$attributes['value']}}</textarea>
        <input class="d-none upload" type="file" data-action="fields--simplemde#upload">
    </div>
@endcomponent
