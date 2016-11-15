@extends('dashboard::layouts.install')

@section('title', trans('install.welcome.title'))
@section('container')


    <div class="install-body container w-xxl padder-lg">
        <div class="panel panel-default wrapper-sm">
            <div class="panel-body">

                <div class="center w-xs">
                    <img src="/orchid/img/logo.svg" class="img-responsive">
                </div>
                <div class="page-header text-center">
                    <h1>Orchid</h1>
                </div>

                <p class="padder-v">{{ trans('install.welcome.message') }}</p>

                <form class="form" method="get" action="{{ route('dashboard::environment') }}">
                    <div class="form-group">
                    <label>Select language</label>
                        <select class="form-control" name="language">
                            <option value="en">English</option>
                            <option value="ru">Русский язык</option>
                        </select>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary">{{ trans('install.next') }}</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


@stop
