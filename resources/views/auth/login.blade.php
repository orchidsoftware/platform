@extends('dashboard::layouts.auth')

@section('content')

    <p class="m-t-lg">{{trans('dashboard::auth/account.title')}}</p>

    <form class="m-t-md" role="form" method="POST" action="{{  url('/dashboard/login') }}">
        {!! csrf_field() !!}

        <div class="form-group form-group-default {{ $errors->has('email') ? ' has-error' : '' }}">
            <label>Email</label>
            <div class="controls">
                <input type="email" name="email" placeholder="{{trans('dashboard::auth/account.enter_email')}}"
                       class="form-control" required
                       value="{{ old('email') }}">

                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                @endif
            </div>
        </div>


        <div class="form-group form-group-default {{ $errors->has('password') ? ' has-error' : '' }}">
            <label>{{trans('dashboard::auth/account.password')}}</label>
            <div class="controls">
                <input type="password" class="form-control" name="password"
                       placeholder="{{trans('dashboard::auth/account.enter_password')}}" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                </span>
                @endif
            </div>
        </div>

        <div class="form-group row v-center">
            <div class="col-xs-5">
                <div class="checkbox">
                    <label class="i-checks">
                        <input type="checkbox" checked
                               name="remember"><i></i> {{trans('dashboard::auth/account.remember_me')}}
                    </label>
                </div>
            </div>
            <div class="col-xs-7 text-right">
                <a href="{{ url('/dashboard/password/reset') }}"
                   class="text-primary small">{{trans('dashboard::auth/account.forgot_password')}}</a>
            </div>
        </div>


        <button class="btn btn-primary m-t-md" type="submit">{{trans('dashboard::auth/account.login')}}</button>
    </form>




@endsection
