<button
        data-controller="button"
        data-turbo="{{ var_export($turbo) }}"
        @empty(!$confirm)
            data-action="button#confirm"
            data-button-confirm="{{ $confirm }}"
        @endempty
    {{ $attributes }}>

    @isset($icon)
        <x-orchid-icon :path="$icon" class="overflow-visible"/>
    @endisset

    {{ $name ?? '' }}
</button>
