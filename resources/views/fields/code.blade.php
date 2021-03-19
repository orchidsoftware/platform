@component($typeForm, get_defined_vars())
    <div
        data-controller="code"
        data-code-language="{{$language}}"
        data-code-line-numbers="{{$lineNumbers}}"
        data-code-default-Theme="{{$defaultTheme}}"
    >
        <div class="code border position-relative w-100" style="min-height: {{ $attributes['height'] }}"></div>
        <input type="hidden" {{ $attributes }}>
    </div>
@endcomponent
