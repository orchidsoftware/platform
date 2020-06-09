@extends('platform::auth')
@section('title',__('Two-Factor Authentication'))

@section('content')
    <h1 class="h5 text-black">
        <i class="icon-screen-smartphone h4 mr-1"></i>
        {{__('Two-Factor Authentication')}}
    </h1>

    <form class="m-t-md"
          role="form"
          method="POST"
          data-controller="layouts--form"
          data-action="layouts--form#submit"
          data-layouts--form-button-animate="#button-login"
          data-layouts--form-button-text="{{ __('Loading...') }}"
          action="{{ route('platform.login.token.auth') }}">
        @csrf

        <div class="form-group">
            <p>
                {{ __('This account is protected by two-factor authentication.') }}<br>
                {{ __('Please enter your code below to proceed.') }}
            </p>
            {!!
                \Orchid\Screen\Fields\Input::make('token')
                ->autofocus()
                ->placeholder('Verification code from application')
                ->title('Authentication code:')
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
                    <i class="icon-login text-xs mr-2"></i> {{__('Login')}}
                </button>
            </div>
        </div>
    </form>

@endsection
