<div class="form-group">

    <label class="form-label">
        {{__('Email address')}}
    </label>

    {!!  \Orchid\Screen\Fields\Input::make('email')
        ->type('email')
        ->required()
        ->tabindex(1)
        ->autofocus()
        ->placeholder(__('Enter your email'))
    !!}
</div>

<div class="form-group">
    <label class="form-label w-100">
        {{__('Password')}}
    </label>

    {!!  \Orchid\Screen\Fields\Password::make('password')
        ->required()
        ->tabindex(2)
        ->placeholder(__('Enter your password'))
    !!}
</div>

<div class="row">
    <div class="form-group col-md-6 col-xs-12">
        <label class="custom-control custom-checkbox">
            <input type="hidden" name="remember">
            <input type="checkbox" name="remember" value="true"
                   class="custom-control-input" {{ !old('remember') || old('remember') === 'true'  ? 'checked' : '' }}>
            <span class="custom-control-label"> {{__('Remember Me')}}</span>
        </label>
    </div>
    <div class="form-group col-md-6 col-xs-12">
        <button id="button-login" type="submit" class="btn btn-default btn-block" tabindex="3">
            <x-orchid-icon path="login" class="text-xs mr-2"/>
            {{__('Login')}}
        </button>
    </div>
</div>
