@extends('platform::layouts.auth')
@section('title',trans('platform::auth/account.password_reset'))

@section('content')
    <p class="m-t-lg text-black">{{trans('platform::auth/account.password_reset')}}</p>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
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
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-footer">
            <button class="btn btn-dark btn-block" type="submit">
                <i class="icon-envelope text-xs m-r-xs"></i> {{trans('platform::auth/account.reset')}}
            </button>
        </div>
    </form>
@endsection