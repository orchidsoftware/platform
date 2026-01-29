{!!
    \Orchid\Screen\Fields\Input::make('email')
        ->title(__('Email address'))
        ->type('email')
        ->required()
        ->tabindex(1)
        ->autofocus()
        ->autocomplete('email')
        ->inputmode('email')
        ->placeholder(__('Enter your email'))
        ->requiredWithoutAsterisk()
!!}

{!!
    \Orchid\Screen\Fields\Password::make('password')
        ->title(__('Password'))
        ->required()
        ->autocomplete('current-password')
        ->tabindex(2)
        ->placeholder(__('Enter your password'))
        ->requiredWithoutAsterisk()
!!}

<div class="row align-items-center">
    <div class="col-md-6 col-xs-12">
        {!!
             \Orchid\Screen\Fields\CheckBox::make('remember')
                ->placeholder(__('Remember Me'))
                ->sendTrueOrFalse()
                ->value(old('remember', true))
                ->title(__('Remember Me'))
        !!}
    </div>
    <div class="col-md-6 col-xs-12">
        <button id="button-login" type="submit" class="btn btn-default btn-block" tabindex="3">
            <x-orchid-icon path="bs.box-arrow-in-right"
                           width="1.25em"
                           height="1.25em"
                           class="small me-2"/>
            {{__('Login')}}
        </button>
    </div>
</div>
