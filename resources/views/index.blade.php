@extends('dashboard::layouts.dashboard')

@section('title',trans('dashboard::common.title'))
@section('description',trans('dashboard::common.description'))

@section('content')

    @foreach($widgets as $widget)
        {!! (new $widget)->run() !!}
    @endforeach

@stop
