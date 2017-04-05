@extends('dashboard::layouts.install')

@section('title', trans('dashboard::install.administrator.title'))
@section('descriptions', trans('dashboard::install.administrator.message'))

@section('container')

    <form class="form" method="post" action="{{ route('install::administratorCreate') }}">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control  form-control-grey" placeholder="admin" name="name" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control  form-control-grey" placeholder="admin@gmail.com" name="email"
                   required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control form-control-grey" placeholder="********" name="password"
                   required>
            {!! csrf_field() !!}
        </div>

        <div class="form-group">
            <div class="text-right">
                <button type="submit" class="btn btn-link">
                    {{ trans('dashboard::install.next') }} <i
                            class="ion-ios-arrow-right m-l-xs"> </i>
                </button>
            </div>
        </div>
    </form>
@stop
