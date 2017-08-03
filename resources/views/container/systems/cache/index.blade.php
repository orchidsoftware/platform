@extends('dashboard::layouts.dashboard')


@section('title','Кэширование')
@section('description','Управление кэшированием приложения')


@section('content')



    <!-- main content -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs text-center">


            <div class="col-xs-4">

                <div class="row">
                    <form action="{{route('dashboard.systems.cache')}}" method="POST">
                        <button class="panel padder-v item w-full" type="submit">
                            <div class="h4 text-info font-thin ">Очистить кэш</div>
                            <span class="text-muted text-xs">Flush the application cache</span>
                        </button>
                        <input name="action" type="hidden" value="cache">
                        {{csrf_field()}}
                    </form>
                </div>

                <div class="row">
                    <form action="{{route('dashboard.systems.cache')}}" method="POST">
                        <button class="panel padder-v item  w-full" type="submit">
                            <div class="h4 text-info font-thin">Очистить настройки конфигурации</div>
                            <span class="text-muted text-xs">Create a cache file for faster configuration loading</span>
                        </button>
                        <input name="action" type="hidden" value="config">
                        {{csrf_field()}}
                    </form>
                </div>

                <div class="row">

                    <form action="{{route('dashboard.systems.cache')}}" method="POST">
                        <button class="panel padder-v item  w-full" type="submit">
                            <div class="h4 text-info font-thin">Очистить маршруты</div>
                            <span class="text-muted text-xs">Create a route cache file for faster route registration</span>

                        </button>
                        <input name="action" type="hidden" value="route">
                        {{csrf_field()}}
                    </form>

                </div>
                <div class="row">

                    <form action="{{route('dashboard.systems.cache')}}" method="POST">
                        <button class="panel padder-v item  w-full" type="submit">
                            <div class="h4 text-info font-thin">Очистить отображаемые файлы</div>
                            <span class="text-muted text-xs">Clear all compiled view files</span>

                        </button>
                        <input name="action" type="hidden" value="view">
                        {{csrf_field()}}
                    </form>

                </div>
                <div class="row">

                    <form action="{{route('dashboard.systems.cache')}}" method="POST">
                        <button class="panel padder-v item  w-full" type="submit">
                            <div class="h4 text-info font-thin">Очистить opcache</div>
                            <span class="text-muted text-xs">Resets the contents of the opcode cache</span>

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



