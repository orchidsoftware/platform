@extends('dashboard::layouts.dashboard')
@section('title',$type->name)
@section('description',$type->description)
@section('navbar')
    <div class="text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('dashboard.posts.type.create',$type->slug)}}" class="btn btn-link"><i
                        class="icon-plus"></i> {{trans('dashboard::common.commands.add')}}
            </a>
        </div>
    </div>
@stop


@section('flash_notification.sub_message')
    @if(session('restore'))
        @include('dashboard::container.posts.restore')
    @endif
@stop


@section('content')

    @if($data->count() > 0)

        @include('dashboard::container.layouts.table',[
            'form' => [
                'fields' => $fields,
                'data' => $data,
            ]
        ])

    @else
        <section>
            <div class="bg-white-only bg-auto no-border-xs">

                <div class="jumbotron text-center bg-white not-found">
                    <div>
                        <h3 class="font-thin">{{trans('dashboard::post/base.not_found')}}</h3>
                        <a href="{{ route('dashboard.posts.type.create',$type->slug)}}"
                           class="btn btn-link">{{trans('dashboard::post/base.create')}}</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@stop
