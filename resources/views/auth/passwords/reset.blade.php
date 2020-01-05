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
          action="{{ route('platform.password.email') }}">
        @csrf
        <div class="form-group">
            <label>{{ __('E-Mail Address') }}</label>
            <div class="controls">
                <input type="email"
                       name="email"
                       placeholder="{{ __('Enter your email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required
                       value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback text-danger">
                        {{ $errors->first('email') }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label>{{ __('Password') }}</label>
            <div class="controls">
                <input type="password"
                       name="password"
                       placeholder="{{ __('Password') }}"
                       class="form-control @error('password') is-invalid @enderror"
                       required>
                @error('password')
                    <span class="invalid-feedback text-danger">
                       {{ $errors->first('Password') }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label>{{ __('Confirm Password') }}</label>
            <div class="controls">
                <input type="password"
                       name="password_confirmation"
                       placeholder="{{ __('Confirm Password') }}"
                       class="form-control @error('password_confirmation') is-invalid @enderror"
                       required>
                @error('password_confirmation')
                <span class="invalid-feedback text-danger">
                       {{ $errors->first('password_confirmation') }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-default btn-block" id="button-reset" type="submit">
                <i class="icon-refresh text-xs mr-2"></i> {{ __('Reset Password') }}
            </button>
        </div>
    </form>
@endsection
