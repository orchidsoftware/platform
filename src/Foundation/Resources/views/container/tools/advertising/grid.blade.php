@extends('dashboard::layouts.dashboard')

@section('title', $name)
@section('description',$description)

@section('navbar')
    <div class="col-sm-6 col-xs-12 text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('dashboard.tools.advertising.create')}}" class="btn btn-link"><i class="icon-plus fa fa-2x"></i></a>
        </div>
    </div>
@stop

@section('content')
@stop
