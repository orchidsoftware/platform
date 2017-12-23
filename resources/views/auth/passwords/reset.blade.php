@extends('dashboard::layouts.auth')

@section('content')



    <p class="m-t-lg">Reset Password</p>


    <form class="m-t-md" role="form" method="POST"
          action="{{ route('dashboard.password.email') }}">
        {!! csrf_field() !!}

        <input type="hidden" name="token" value="{{ $token }}">


        <div class="form-group form-group-default {{ $errors->has('email') ? ' has-error' : '' }}">
            <label>Email</label>
            <div class="controls">
                <input type="email" name="email" placeholder="{{trans('dashboard::auth/account.enter_email')}}"
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
            <label>Password</label>
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


        <button class="btn btn-default btn-block m-t-md" type="submit">
            <i class="icon-refresh text-xs m-r-xs"></i> Reset Password
        </button>
    </form>

@endsection
