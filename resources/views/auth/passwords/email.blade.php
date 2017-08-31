@extends('dashboard::layouts.auth')

<!-- Main Content  -->
@section('content')

    <p class="m-t-lg">Reset Password</p>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="m-t-md" role="form" method="POST"
          action="{{ url('/dashboard/password/email') }}">
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


        <button class="btn btn-primary m-t-md" type="submit"><i class="fa fa-btn fa-envelope"></i> Send Password Reset
            Link
        </button>
    </form>

@endsection
