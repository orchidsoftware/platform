<div class="wrapper-md">

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <td>{{trans('dashboard::systems/settings.Name of the site')}}</td>
                        <td>{{$settings->get('name')}}</td>
                    </tr>
                    <tr>
                        <td>{{trans('dashboard::systems/settings.Environment')}}</td>
                        <td>{{$settings->get('env')}}</td>
                    </tr>
                    <tr>
                        <td>{{trans('dashboard::systems/settings.Debugging')}}</td>
                        <td>{{  $settings->get('debug') ? 'true' : 'false' }}</td>
                    </tr>
                    <tr>
                        <td>{{trans('dashboard::systems/settings.Website address')}}</td>
                        <td>{{$settings->get('url')}}</td>
                    </tr>

                    <tr>
                        <td>{{trans('dashboard::systems/settings.Timezone')}}</td>
                        <td>{{$settings->get('timezone')}}</td>
                    </tr>


                    <tr>
                        <td>{{trans('dashboard::systems/settings.Default Language')}}</td>
                        <td>{{$settings->get('locale')}}</td>
                    </tr>

                    <tr>
                        <td>{{trans('dashboard::systems/settings.Replacement language')}}</td>
                        <td>{{$settings->get('fallback_locale')}}</td>
                    </tr>
                    <tr>
                        <td>{{trans('dashboard::systems/settings.The event log')}}</td>
                        <td>{{$settings->get('log')}}</td>
                    </tr>
                    <tr>
                        <td>{{trans('dashboard::systems/settings.Level Event Log')}}</td>
                        <td>{{$settings->get('log_level')}}</td>
                    </tr>


                </table>
            </div>


            <div class="col-md-6">
                <!-- main content -->
                <section class="wrapper-md cache">
                    <div class="no-border-xs text-center">


                        <div class="">

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
            </div>

        </div>
    </div>
</div>
