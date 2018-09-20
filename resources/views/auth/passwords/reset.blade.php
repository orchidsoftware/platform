@extends('platform::layouts.auth')
@section('title',trans('platform::auth/account.password_reset'))

@section('content')
    <p class="m-t-lg text-black">{{trans('platform::auth/account.password_reset')}}</p>
    <form class="m-t-md" role="form" method="POST"
          action="{{ route('platform.password.email') }}">
        @csrf
        <div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
            <label>Email</label>
            <div class="controls">
                <input type="email" name="email" placeholder="{{trans('platform::auth/account.enter_email')}}"
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
            <label>{{trans('platform::auth/account.password')}}</label>
            <div class="controls">
                <input type="password" name="password" placeholder="Password"
                       class="form-control" required>
                @if ($errors->has('Password'))
                    <span class="invalid-feedback text-danger">
                       {{ $errors->first('Password') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
            <label>Confirm Password</label>
            <div class="controls">
                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                       class="form-control" required>
                @if ($errors->has('password_confirmation'))
                    <span class="invalid-feedback text-danger">
                       {{ $errors->first('password_confirmation') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-footer">
            <button class="btn btn-primary btn-block" type="submit">
                <i class="icon-refresh text-xs m-r-xs"></i> {{trans('platform::auth/account.password_reset')}}
            </button>
        </div>
    </form>
@endsection