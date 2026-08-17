<div class="d-flex align-items-center gap-3 rounded border bg-body-tertiary p-3">
    <div class="thumb-md avatar">
        <img src="{{ $lockUser->presenter()->image() }}"
             class="b bg-light"
             alt="{{ $lockUser->presenter()->title() }}"
        >
    </div>
    <div class="d-flex flex-column overflow-hidden">
        <span class="fw-semibold text-truncate">
            {{ $lockUser->presenter()->title() }}
        </span>
        <span class="small text-muted d-block text-truncate">
            {{ $lockUser->presenter()->subTitle() }}
        </span>
    </div>
    <input type="hidden" name="email" required value="{{ $lockUser->email }}">
</div>

<div>
    <input type="hidden" name="remember" value="true">

    {!!
        \Orchid\Screen\Fields\Password::make('password')
            ->required()
            ->autocomplete('current-password')
            ->autofocus()
            ->placeholder(__('Enter your password'))
    !!}

    @error('email')
        <span class="d-block invalid-feedback">
            {{ $errors->first('email') }}
        </span>
    @enderror
</div>

<div class="d-grid gap-3">
    <button id="button-login" type="submit" class="btn btn-dark btn-block">
        <x-orchid-icon path="bs.box-arrow-in-right"
                       width="1.25em"
                       height="1.25em"
                       class="small me-2"/>
        {{ __('Login') }}
    </button>

    <a href="{{ route('orchid.login.lock') }}"
       class="btn btn-link text-decoration-none"
       data-turbo-prefetch="false"
    >
        {{ __('Use another account') }}
    </a>
</div>
