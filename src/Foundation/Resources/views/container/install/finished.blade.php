@extends('dashboard::layouts.install')

@section('title', trans('install.final.title'))
@section('container')

    <div class="install-body container w-xxl padder-lg">
        <div class="panel panel-default wrapper-sm">
            <div class="panel-body">

                <div class="page-header text-center">
                    <h1> <i class="fa text-success fa-check-square-o" aria-hidden="true"></i> Install</h1>
                </div>

                <p class="padder-v">{{ session('message')['message'] }}</p>


                    <div class="btn-group btn-group-justified" role="group">
                        <a href="/dashboard" class="btn btn-primary">Dashboard</a>
                        <a href="/" class="btn btn-primary">{{ trans('install.final.exit') }}</a>
                    </div>


            </div>
        </div>
    </div>

@stop
