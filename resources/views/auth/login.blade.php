@extends('platform::layouts.auth')
@section('title',__('Sign in to your account'))

@section('content')
    <p class="m-t-lg text-black">{{__('Sign in to your account')}}</p>
    <form class="m-t-md"
          role="form"
          method="POST"
          data-controller="layouts--form"
          data-action="layouts--form#submit"
          data-layouts--form-button-animate="#button-login"
          data-layouts--form-button-text="{{ __('Loading...') }}"
          action="{{ route('platform.login.auth') }}">
        @csrf
    <div class="form-group">
        <label class="form-label">{{__('Email address')}}</label>
        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" required
               value="{{ old('email') }}"
               placeholder="{{__('Enter your email')}}">
        @if ($errors->has('email'))
            <span class="invalid-feedback text-danger">
                {{ $errors->first('email') }}
            </span>
        @endif
    </div>
    <div class="form-group">
        <label class="form-label w-full">
            {{__('Password')}}
            <a href="{{ route('platform.password.request') }}" class="float-right small">{{__('Forgot your password?')}}</a>
        </label>
        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password"
               value="{{ old('password') }}"
               placeholder="{{__('Enter your password')}}" required>
        @if ($errors->has('password'))
            <span class="invalid-feedback text-danger">
                {{ $errors->first('password') }}
            </span>
        @endif
    </div>

    <div class="row">
        <div class="form-group col-md-6 col-xs-12">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}>
                <span class="custom-control-label"> {{__('Remember Me')}}</span>
            </label>
        </div>
        <div class="form-group col-md-6 col-xs-12">
            <button id="button-login" type="submit" class="btn btn-default btn-block">
                <i class="icon-login text-xs m-r-xs"></i> {{__('Login')}}
            </button>
        </div>
    </div>
    </form>
@endsection