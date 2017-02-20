@extends('dashboard::layouts.auth')

@section('content')

    <p class="m-t-lg">Войдите в свой аккаунт</p>

    <form class="m-t-md" role="form" method="POST" action="{{  url('/dashboard/login') }}">
        {!! csrf_field() !!}

        <div class="form-group form-group-default {{ $errors->has('email') ? ' has-error' : '' }}">
            <label>Email</label>
            <div class="controls">
                <input type="email" name="email" placeholder="Ваша электронная почта" class="form-control" required
                       value="{{ old('email') }}">

                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                @endif
            </div>
        </div>


        <div class="form-group form-group-default {{ $errors->has('password') ? ' has-error' : '' }}">
            <label>Пароль</label>
            <div class="controls">
                <input type="password" class="form-control" name="password" placeholder="Ваш пароль" required>

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
                        <input type="checkbox" checked name="remember"><i></i> Запомнить меня
                    </label>
                </div>
            </div>
            <div class="col-xs-7 text-right">
                <a href="{{ url('/dashboard/password/reset') }}" class="text-primary small">Забыли пароль?</a>
            </div>
        </div>


        <button class="btn btn-primary m-t-md" type="submit">Войти</button>
    </form>




@endsection
