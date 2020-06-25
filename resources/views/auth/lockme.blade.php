<div class="form-group v-center">
    <span class="thumb-sm avatar mr-3">
        <img src="{{ $lockUser->presenter()->image() }}" class="b bg-light" alt="test">
    </span>
    <span style="width:125px;font-size: 0.85em;">
        <span class="text-ellipsis">{{ $lockUser->presenter()->title() }}</span>
        <span class="text-muted d-block text-ellipsis">{{ $lockUser->presenter()->subTitle() }}</span>
    </span>
    <input type="hidden" name="email" required value="{{ $lockUser->email }}">
</div>

@error('email')
    <span class="d-block invalid-feedback text-danger">
            {{ $errors->first('email') }}
    </span>
@enderror

<div class="form-group">
    <input type="hidden" name="remember" value="true">

    {!!  \Orchid\Screen\Fields\Password::make('password')
            ->required()
            ->tabindex(1)
            ->autofocus()
            ->placeholder(__('Enter your password'))
    !!}
</div>

<div class="row">
    <div class="form-group col-md-6 col-xs-12">
        <a href="{{ route('platform.login.lock') }}" class="small">
            {{__('Sign in with another user.')}}
        </a>
    </div>
    <div class="form-group col-md-6 col-xs-12">
        <button id="button-login" type="submit" class="btn btn-default btn-block" tabindex="2">
            <x-orchid-icon path="login" class=" text-xs mr-2"/> {{__('Login')}}
        </button>
    </div>
</div>
