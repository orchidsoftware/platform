@extends('platform::layouts.auth')
@section('title',__('Reset Password'))

@section('content')
    <p class="m-t-lg text-black">{{ __('Reset Password') }}</p>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form class="m-t-md"
          role="form"
          method="POST"
          data-controller="layouts--form"
          data-action="layouts--form#submit"
          data-layouts--form-button-animate="#button-email"
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
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-default btn-block" id="button-email" type="submit">
                <i class="icon-envelope text-xs m-r-xs"></i>  {{ __('Send Password Reset Link') }}
            </button>
        </div>
    </form>
@endsection