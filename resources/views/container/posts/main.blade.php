@extends('platform::layouts.dashboard')
@section('title',$type->name)
@section('description',$type->description)
@section('navbar')
    <div class="text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('platform.posts.type.create',$type->slug)}}" class="btn btn-link"><i
                        class="icon-plus"></i> {{__('Add')}}
            </a>
        </div>
    </div>
@stop

@section('flash_notification.sub_message')
    @includeWhen(session('restore'),'platform::container.posts.restore')
@stop

@section('content')

        @include('platform::container.layouts.table',[
            'fields'    => $fields,
            'data'      => $data,
            'filters'   => $type->showFilterDashboard()
        ])
@stop
