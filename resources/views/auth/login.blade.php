@extends('platform::layouts.auth')
@section('title',trans('platform::auth/account.title'))

@section('content')

    <p class="m-t-lg text-black">{{trans('platform::auth/account.title')}}</p>
    <form class="m-t-md" role="form" method="POST" action="{{ route('platform.login.auth') }}">
        @csrf
    <div class="form-group">
        <label class="form-label">Email address</label>
        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" required
               value="{{ old('email') }}"
               placeholder="{{trans('platform::auth/account.enter_email')}}">
        @if ($errors->has('email'))
            <span class="invalid-feedback text-danger">
                {{ $errors->first('email') }}
            </span>
        @endif
    </div>
    <div class="form-group">
        <label class="form-label w-full">
            {{trans('platform::auth/account.password')}}
            <a href="{{ route('platform.password.request') }}" class="float-right small">{{trans('platform::auth/account.forgot_password')}}</a>
        </label>
        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password"
               value="{{ old('password') }}"
               placeholder="{{trans('platform::auth/account.enter_password')}}" required>
        @if ($errors->has('password'))
            <span class="invalid-feedback text-danger">
                {{ $errors->first('password') }}
            </span>
        @endif
    </div>
    <div class="form-group">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input">
            <span class="custom-control-label"> {{trans('platform::auth/account.remember_me')}}</span>
        </label>
    </div>
    <div class="form-footer">
        <button type="submit" class="btn btn-dark btn-block">
            <i class="icon-login text-xs m-r-xs"></i> {{trans('platform::auth/account.login')}}
        </button>
    </div>
    </form>
@endsection