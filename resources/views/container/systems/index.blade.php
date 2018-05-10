@extends('dashboard::layouts.dashboard')

@section('title','Systems')
@section('description', 'Global for Systems')

@section('content')

<div class="admin-wrapper bg-white not-found">

    <div class="container wrapper-md">

        <div class="row">
            {!! Dashboard::menu()->render('SystemsMenu',' dashboard::partials.systems.systemsMenu') !!}
        </div>

        {{--
        <div class="col-md-6">
            <!-- main content -->
            <section class="wrapper-md cache">
                <div class="no-border-xs">
                    <div class="">
                        <div class="row">
                            <form action="{{route('dashboard.systems.cache',['action'=>'cache'])}}" method="POST">
                                <button class="panel padder-v item w-full" type="submit">
                                    <div class="h4 text-info font-thin ">{{trans('dashboard::systems/cache.cache')}}</div>
                                    <span class="text-muted text-xs">{{trans('dashboard::systems/cache.cache.description')}}</span>
                                </button>
                                <input name="action" type="hidden" value="cache">
                                @csrf
                            </form>
                        </div>
                        <div class="row">
                            <form action="{{route('dashboard.systems.cache')}}" method="POST">
                                <button class="panel padder-v item  w-full" type="submit">
                                    <div class="h4 text-info font-thin">{{trans('dashboard::systems/cache.config')}}</div>
                                    <span class="text-muted text-xs">{{trans('dashboard::systems/cache.config.description')}}</span>
                                </button>
                                <input name="action" type="hidden" value="config">
                                @csrf
                            </form>
                        </div>
                        <div class="row">
                            <form action="{{route('dashboard.systems.cache')}}" method="POST">
                                <button class="panel padder-v item  w-full" type="submit">
                                    <div class="h4 text-info font-thin">{{trans('dashboard::systems/cache.route')}}</div>
                                    <span class="text-muted text-xs">{{trans('dashboard::systems/cache.route.description')}}</span>
                                </button>
                                <input name="action" type="hidden" value="route">
                                @csrf
                            </form>
                        </div>
                        <div class="row">
                            <form action="{{route('dashboard.systems.cache')}}" method="POST">
                                <button class="panel padder-v item  w-full" type="submit">
                                    <div class="h4 text-info font-thin">{{trans('dashboard::systems/cache.view')}}</div>
                                    <span class="text-muted text-xs">{{trans('dashboard::systems/cache.view.description')}}</span>
                                </button>
                                <input name="action" type="hidden" value="view">
                                @csrf
                            </form>
                        </div>
                        <div class="row">
                            <form action="{{route('dashboard.systems.cache')}}" method="POST">
                                <button class="panel padder-v item  w-full" type="submit">
                                    <div class="h4 text-info font-thin">{{trans('dashboard::systems/cache.opcache')}}</div>
                                    <span class="text-muted text-xs">{{trans('dashboard::systems/cache.opcache.description')}}</span>
                                </button>
                                <input name="action" type="hidden" value="opcache">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- / main content -->
        </div>
        --}}

    </div>

</div>


@stop