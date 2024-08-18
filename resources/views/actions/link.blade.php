@component($typeForm, get_defined_vars())
    <a
        data-turbo="{{ var_export($turbo) }}"
        {{ $attributes }}
    >
        @isset($icon)
            <x-orchid-icon :path="$icon" class="overflow-visible"/>
        @endisset

        <span>{{ $name ?? '' }}</span>
    </a>
@endcomponent
