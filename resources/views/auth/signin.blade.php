{!!
    \Orchid\Screen\Fields\Input::make('email')
        ->title(__('Email address'))
        ->type('email')
        ->required()
        ->autofocus()
        ->autocomplete('email')
        ->inputmode('email')
        ->placeholder('name@example.com')
        ->requiredWithoutAsterisk()
!!}

{!!
    \Orchid\Screen\Fields\Password::make('password')
        ->title(__('Password'))
        ->required()
        ->autocomplete('current-password')
        ->placeholder(__('Enter your password'))
        ->requiredWithoutAsterisk()
!!}

<div class="row g-3">
    <div class="col-12">
        {!!
             \Orchid\Screen\Fields\CheckBox::make('remember')
                ->placeholder(__('Stay signed in on this device'))
                ->sendTrueOrFalse()
                ->value(old('remember', true))
        !!}
    </div>
    <div class="col-12">
        <button id="button-login" type="submit" class="btn btn-dark btn-block">
            <x-orchid-icon path="bs.box-arrow-in-right"
                           width="1.25em"
                           height="1.25em"
                           class="small me-2"/>
            {{ __('Login') }}
        </button>
    </div>
</div>
