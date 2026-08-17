<div class="input-icon" @if ($revealable) data-controller="password" @endif>
    <input {{ $attributes }} @if ($revealable) data-password-target="password" @endif>

    @if ($revealable)
    <button type="button"
            class="input-icon-addon"
            data-password-target="toggle"
            data-show-label="{{ __('Show password') }}"
            data-hide-label="{{ __('Hide password') }}"
            data-action="click->password#change"
            aria-label="{{ __('Show password') }}">

        <span data-password-target="iconShow" aria-hidden="true">
            <x-orchid-icon path="bs.eye" class="small" width="1.25em" height="1.25em"/>
        </span>

        <span data-password-target="iconLock" class="d-none" aria-hidden="true">
            <x-orchid-icon path="bs.eye-slash" class="small" width="1.25em" height="1.25em"/>
        </span>
    </button>
    @endif
</div>
