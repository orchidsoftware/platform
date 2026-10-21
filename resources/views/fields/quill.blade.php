<div data-controller="quill"
     data-quill-toolbar='@json($toolbar)'
     data-quill-base64='@json($base64)'
     data-quill-groups="{{$attributes['groups'] ?? ''}}"
     data-theme="{{$theme ?? 'inlite'}}"
>
    <div class="quill p-3 position-relative" id="quill-wrapper-{{$id}}"
         style="min-height: {{ $attributes['height'] }}">
    </div>
    <textarea {{ $attributes->merge(['class' => 'd-none']) }}>{{ $value ?? '' }}</textarea>
</div>
