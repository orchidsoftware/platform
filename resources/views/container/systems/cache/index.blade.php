@extends('dashboard::layouts.dashboard')


@section('title','Кэширование')
@section('description','Управление кэшированием приложения')

@section('content')


<!-- main content -->
<section class="wrapper-md cache">
    <div class="no-border-xs text-center">


        <div class="col-md-4 col-xs-12">

            <div class="row">
                <form action="{{route('dashboard.systems.cache')}}" method="POST">
                    <button class="panel padder-v item w-full" type="submit">
                        <div class="h4 text-info font-thin ">{{trans('dashboard::systems/cache.cache')}}</div>
                        <span class="text-muted text-xs">{{trans('dashboard::systems/cache.cache.description')}}</span>
                    </button>
                    <input name="action" type="hidden" value="cache">
                    {{csrf_field()}}
                </form>
            </div>
            <div class="row">
                <form action="{{route('dashboard.systems.cache')}}" method="POST">
                    <button class="panel padder-v item  w-full" type="submit">
                        <div class="h4 text-info font-thin">{{trans('dashboard::systems/cache.config')}}</div>
                        <span class="text-muted text-xs">{{trans('dashboard::systems/cache.config.description')}}</span>
                    </button>
                    <input name="action" type="hidden" value="config">
                    {{csrf_field()}}
                </form>
            </div>
            <div class="row">

                <form action="{{route('dashboard.systems.cache')}}" method="POST">
                    <button class="panel padder-v item  w-full" type="submit">
                        <div class="h4 text-info font-thin">{{trans('dashboard::systems/cache.route')}}</div>
                        <span class="text-muted text-xs">{{trans('dashboard::systems/cache.route.description')}}</span>

                    </button>
                    <input name="action" type="hidden" value="route">
                    {{csrf_field()}}
                </form>

            </div>
            <div class="row">

                <form action="{{route('dashboard.systems.cache')}}" method="POST">
                    <button class="panel padder-v item  w-full" type="submit">
                        <div class="h4 text-info font-thin">{{trans('dashboard::systems/cache.view')}}</div>
                        <span class="text-muted text-xs">{{trans('dashboard::systems/cache.view.description')}}</span>

                    </button>
                    <input name="action" type="hidden" value="view">
                    {{csrf_field()}}
                </form>

            </div>
            <div class="row">

                <form action="{{route('dashboard.systems.cache')}}" method="POST">
                    <button class="panel padder-v item  w-full" type="submit">
                        <div class="h4 text-info font-thin">{{trans('dashboard::systems/cache.opcache')}}</div>
                        <span class="text-muted text-xs">{{trans('dashboard::systems/cache.opcache.description')}}</span>

                    </button>
                    <input name="action" type="hidden" value="opcache">
                    {{csrf_field()}}
                </form>

            </div>
        </div>


    </div>


</section>
<!-- / main content -->



@stop
