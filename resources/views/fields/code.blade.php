@php
    $inputAttributes = $attributes->except(['height', 'language', 'lineNumbers']);
@endphp

<div
    class="markup-editor-wrapper"
    data-controller="code"
    data-code-language-value="{{ $language }}"
    data-code-line-numbers-value="{{ $lineNumbers ? 'true' : 'false' }}"
>
    <div
        class="markup-editor border"
        data-code-target="editor"
        style="min-height: {{ $attributes['height'] }}"
    ></div>

    <textarea
        data-code-target="textarea"
        {{ $inputAttributes->merge(['class' => 'd-none']) }}
    >{{ $value ?? '' }}</textarea>
</div>
