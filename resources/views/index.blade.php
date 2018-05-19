@extends('platform::layouts.dashboard')

@section('title',trans('platform::common.title'))
@section('description',trans('platform::common.description'))

@section('content')

    @foreach($widgets as $widget)
        {!! (new $widget)->handler() !!}
    @endforeach

@stop
