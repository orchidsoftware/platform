@extends('platform::layouts.auth')
@section('title',__('Reset Password'))

@section('content')
    <p class="m-t-lg text-black">{{ __('Reset Password') }}</p>
    <form class="m-t-md"
          role="form"
          method="POST"
          data-controller="layouts--form"
          data-action="layouts--form#submit"
          data-layouts--form-button-animate="#button-reset"
          data-layouts--form-button-text="{{ __('Loading...') }}"
          action="{{ route('platform.password.email') }}">
        @csrf
        <div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
            <label>{{ __('E-Mail Address') }}</label>
            <div class="controls">
                <input type="email" name="email" placeholder="{{ __('Enter your email') }}"
                       class="form-control" required
                       value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="invalid-feedback text-danger">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('password') ? ' is-invalid' : '' }}">
            <label>{{ __('Password') }}</label>
            <div class="controls">
                <input type="password" name="password" placeholder="{{ __('Password') }}"
                       class="form-control" required>
                @if ($errors->has('Password'))
                    <span class="invalid-feedback text-danger">
                       {{ $errors->first('Password') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
            <label>{{ __('Confirm Password') }}</label>
            <div class="controls">
                <input type="password" name="password_confirmation" placeholder="{{ __('Confirm Password') }}"
                       class="form-control" required>
                @if ($errors->has('password_confirmation'))
                    <span class="invalid-feedback text-danger">
                       {{ $errors->first('password_confirmation') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-default btn-block" id="button-reset" type="submit">
                <i class="icon-refresh text-xs m-r-xs"></i>  {{ __('Reset Password') }}
            </button>
        </div>
    </form>
@endsection