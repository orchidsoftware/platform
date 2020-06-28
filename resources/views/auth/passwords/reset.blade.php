@extends('platform::auth')
@section('title',__('Reset Password'))

@section('content')
    <h1 class="h5 text-black">{{ __('Reset Password') }}</h1>
    <form class="m-t-md"
          role="form"
          method="POST"
          data-controller="layouts--form"
          data-action="layouts--form#submit"
          data-layouts--form-button-animate="#button-reset"
          data-layouts--form-button-text="{{ __('Loading...') }}"
          action="{{ route('platform.password.update') }}">
        @csrf
        <div class="form-group">
            <label>{{ __('E-Mail Address') }}</label>
            {!!  \Orchid\Screen\Fields\Input::make('email')
                ->type('email')
                ->required()
                ->placeholder(__('Enter your email'))
            !!}
        </div>
        <div class="form-group">
            <label>{{ __('Password') }}</label>
            {!!  \Orchid\Screen\Fields\Password::make('password')
                ->required()
                ->placeholder(__('Enter your password'))
            !!}
        </div>
        <div class="form-group">
            <label>{{ __('Confirm Password') }}</label>
            {!!  \Orchid\Screen\Fields\Password::make('password_confirmation')
                ->required()
                ->placeholder(__('Enter your password'))
            !!}
        </div>
        <div class="form-group">
            <button class="btn btn-default btn-block" id="button-reset" type="submit">
                <i class="icon-refresh text-xs mr-2"></i> {{ __('Reset Password') }}
            </button>
        </div>
    </form>
@endsection
