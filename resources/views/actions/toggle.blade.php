@component($typeForm, get_defined_vars())
    <div class="form-check form-switch" data-controller="toggle">
        <input {{ $attributes }}
               data-turbo="{{ var_export($turbo) }}"
               data-action="toggle#toggle"
               @checked($status)
               id="{{ $id }}"
        >
        <label class="form-check-label" for="{{ $id }}">{{ $name ?? '' }}</label>

        <button
            data-controller="button"
            data-turbo="{{ var_export($turbo) }}"
            @empty(!$confirm)
                data-action="button#confirm"
                data-button-confirm="{{ $confirm }}"
            @endempty
            type="submit"
            data-toggle-target="button"
            {{ $attributes->merge(['class' => 'd-none'])->except(['type']) }}>
        </button>
    </div>
@endcomponent
