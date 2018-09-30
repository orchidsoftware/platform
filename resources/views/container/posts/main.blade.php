@extends('platform::layouts.dashboard')
@section('title',$type->name)
@section('description',$type->description)
@section('navbar')
    <div class="text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('platform.posts.type.create',$type->slug)}}" class="btn btn-link"><i
                        class="icon-plus"></i> {{trans('platform::common.commands.add')}}
            </a>
        </div>
    </div>
@stop

@section('flash_notification.sub_message')
    @includeWhen(session('restore'),'platform::container.posts.restore')
@stop


@section('content')

    @empty($data->count())

        <section>
            <div class="bg-white-only bg-auto no-border-xs">

                <div class="text-center bg-white app-content-center">
                    <div>
                        <h3 class="font-thin">{{trans('platform::post/base.not_found')}}</h3>
                        <a href="{{ route('platform.posts.type.create',$type->slug)}}"
                           class="btn btn-link">{{trans('platform::post/base.create')}}</a>
                    </div>
                </div>
            </div>
        </section>

    @else
        @include('platform::container.layouts.table',[
            'fields'    => $fields,
            'data'      => $data,
            'filters'   => $type->showFilterDashboard()
        ])
    @endempty


@stop
