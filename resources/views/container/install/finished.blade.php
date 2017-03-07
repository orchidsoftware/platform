@extends('dashboard::layouts.install')

@section('title', trans('install.final.title'))
@section('descriptions', trans('install.final.message'))

@section('container')



    <div class="page-header text-center">
        <h4> <i class="fa text-success fa-check-square-o" aria-hidden="true"></i> {{trans('install.final.message')}}</h4>
    </div>

    <p class="padder-v">{{ session('message')['message'] }}</p>


    <div class="btn-group btn-group-justified" role="group">
        <a href="/" class="btn btn-link">{{ trans('install.final.exit') }}</a>
    </div>



@stop