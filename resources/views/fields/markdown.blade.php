<div class="markdown-editor-wrapper d-flex flex-column gap-3"
     data-controller="markdown">

    @empty(!$toolbarGroups)
        <div
            class="markdown-editor-toolbar"
            role="toolbar"
            aria-label="{{ __('Formatting toolbar') }}"
        >
            @foreach ($toolbarGroups as $index => $buttons)
                <div class="btn-group btn-group"
                     role="group"
                     aria-label="{{ __('Tool group :number', ['number' => $index + 1]) }}">
                    @foreach ($buttons as [$title, $action, $icon])
                        <button
                            type="button"
                            class="btn btn-light"
                            title="{{ $title }}"
                            data-action="markdown#{{ $action }}"
                        >
                            <x-orchid-icon :path="$icon" class="markdown-editor-icon" />
                        </button>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endempty

    <div class="markdown-editor border" data-markdown-target="editor"></div>

    <textarea
        class="d-none"
        data-markdown-target="textarea"
        {{ $attributes }}
    >{{ $value ?? '' }}</textarea>

    <input class="d-none upload" type="file" data-action="markdown#upload" />
</div>
