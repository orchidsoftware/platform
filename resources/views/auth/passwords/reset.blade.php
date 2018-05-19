@extends('platform::layouts.auth')
@section('content')
    <p class="m-t-lg">{{trans('platform::auth/account.password_reset')}}</p>
    <form class="m-t-md" role="form" method="POST"
          action="{{ route('platform.password.email') }}">
        @csrf
        <div class="form-group form-group-default {{ $errors->has('email') ? ' has-error' : '' }}">
            <label>Email</label>
            <div class="controls">
                <input type="email" name="email" placeholder="{{trans('platform::auth/account.enter_email')}}"
                       class="form-control" required
                       value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="form-text text-muted">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group form-group-default {{ $errors->has('password') ? ' has-error' : '' }}">
            <label>{{trans('platform::auth/account.password')}}</label>
            <div class="controls">
                <input type="password" name="password" placeholder="Password"
                       class="form-control" required>
                @if ($errors->has('Password'))
                    <span class="form-text text-muted">
                        <strong>{{ $errors->first('Password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group form-group-default {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label>Confirm Password</label>
            <div class="controls">
                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                       class="form-control" required>
                @if ($errors->has('password_confirmation'))
                    <span class="form-text text-muted">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <button class="btn btn-primary m-t-md" type="submit">
            <i class="icon-refresh text-xs m-r-xs"></i> {{trans('platform::auth/account.password_reset')}}
        </button>
    </form>
@endsection