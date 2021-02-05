@component($typeForm, get_defined_vars())
    <div class="simplemde-wrapper" data-controller="simplemde">
        <textarea {{ $attributes }}>{{$attributes['value']}}</textarea>
        <input class="d-none upload" type="file" data-action="simplemde#upload">
    </div>
@endcomponent
