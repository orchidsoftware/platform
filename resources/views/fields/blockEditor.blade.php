<div class="block-editor-wrapper d-flex flex-column"
     data-controller="block-editor"
     data-block-editor-readonly-value='@json((bool) ($attributes['readonly'] ?? false))'
     data-block-editor-disabled-value='@json((bool) ($attributes['disabled'] ?? false))'
     data-block-editor-tools-value='@json($toolbarButtons)'>

    <div
        class="block-editor"
        data-block-editor-target="canvas"
        aria-label="{{ $attributes['placeholder'] ?? __('Content') }}"
    ></div>

    <textarea
        data-block-editor-target="textarea"
        {{ $attributes->merge(['class' => 'd-none']) }}
    >{{ $encodedValue }}</textarea>
</div>
