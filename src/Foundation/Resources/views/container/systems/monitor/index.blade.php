@extends('dashboard::layouts.dashboard')


@section('title','Монитор')
@section('description','Информация о состоянии сервера')



@section('content')


    <!-- main content -->
    <section class="wrapper-lg bg-white col-md-6">


        <div class="row">
            <!-- Hardware -->
            <div class="col-lg-6">
                <h4><i class="fa m-r-sm fa-server"></i> {{trans('dashboard::systems/monitor.Hardware.Title')}}
                </h4>

                <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td><p>{{trans('dashboard::systems/monitor.Hardware.Uptime')}}: </p></td>
                        <td><p class="text-right">{{ $hardware->uptime }}</p></td>
                    </tr>
                    <tr>
                        <td><p>{{trans('dashboard::systems/monitor.Hardware.Board Temperature')}}: </p>
                        </td>
                        <td><p class="text-right">{{ $hardware->temperature }}</p></td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <!-- Network -->
            <div class="col-lg-6">
                <h4><i class="fa m-r-sm fa-exchange"></i> {{trans('dashboard::systems/monitor.Network.Title')}}
                </h4>

                <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td><p>{{trans('dashboard::systems/monitor.Network.Down')}}:</p></td>
                        <td><p class="text-right">{{ $network->down }}</p></td>
                    </tr>
                    <tr>
                        <td><p>{{trans('dashboard::systems/monitor.Network.Up')}}:</p></td>
                        <td><p class="text-right">{{ $network->up }}</p></td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Load Average -->
            <div class="col-lg-6">
                <h4>
                    <i class="fa m-r-sm fa-area-chart"></i> {{trans('dashboard::systems/monitor.CPU Load Average.Title')}}
                </h4>

                <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <td><p>1 {{trans('dashboard::systems/monitor.CPU Load Average.min')}}:</p></td>
                        <td><p class="text-right"><span
                                        class="text-muted">{{ $loadAverage->one_min['percent'] }}
                                    %</span>&nbsp;
                                &nbsp; &nbsp;{{ $loadAverage->one_min['average'] }}
                            </p></td>
                    </tr>
                    <tr>
                        <td><p>5 {{trans('dashboard::systems/monitor.CPU Load Average.min')}}:</p></td>
                        <td><p class="text-right"><span
                                        class="text-muted">{{ $loadAverage->five_mins['percent'] }}
                                    %</span>&nbsp;
                                &nbsp; &nbsp;{{ $loadAverage->five_mins['average'] }}
                            </p></td>
                    </tr>
                    <tr>
                        <td><p>15 {{trans('dashboard::systems/monitor.CPU Load Average.min')}}:</p></td>
                        <td><p class="text-right"><span
                                        class="text-muted">{{ $loadAverage->one_min['percent'] }}
                                    %</span>&nbsp;
                                &nbsp; &nbsp;{{ $loadAverage->fifteen_mins['average'] }}
                            </p></td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Memory -->
                <h4><i class="fa m-r-sm fa-sliders"></i> {{trans('dashboard::systems/monitor.Memory.Title')}}
                </h4>

                <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <td colspan="4">
                            <div class="row row-memory">
                                <div class="col-xs-9 no-padder">
                                    <div class="progress m-n">
                                        <div class="progress-bar progress-bar-danger"
                                             role="progressbar"
                                             style="width: {{$memory->used->percentage}}%">
                                            <span class="sr-only">{{$memory->used->percentage}}% Used</span>
                                        </div>
                                        <div class="progress-bar progress-bar-warning"
                                             role="progressbar"
                                             style="width: {{$memory->buffers->percentage}}%">
                                                            <span class="sr-only">{{$memory->buffers->percentage}}
                                                                % Buffers</span>
                                        </div>
                                        <div class="progress-bar progress-bar-info"
                                             role="progressbar"
                                             style="width: {{$memory->cache->percentage}}%">
                                            <span class="sr-only">{{$memory->cache->percentage}}% Cache</span>
                                        </div>
                                        <div class="progress-bar progress-bar-success"
                                             role="progressbar"
                                             style="width: {{$memory->free->percentage}}%">
                                            <span class="sr-only"> {{$memory->free->percentage}}% Free</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3 no-padder">
                                    <p class="text-right">{{ $memory->total->pretty  }}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="membar-key">
                            <p class="membar-key-used">
                                {{ $memory->used->percentage }}%
                            </p>
                        </td>
                        <td>
                            <p class="text-danger">{{trans('dashboard::systems/monitor.Memory.Used')}}</p>
                        </td>
                        <td class="membar-key">
                            <p class="membar-key-buffers">
                                {{ $memory->buffers->percentage }}%
                            </p>
                        </td>
                        <td>
                            <p class="text-warning">{{trans('dashboard::systems/monitor.Memory.Buffers')}}</p>
                        </td>
                    </tr>

                    <tr>
                        <td class="membar-key">
                            <p class="membar-key-cache">
                                {{ $memory->cache->percentage }}%
                            </p>
                        </td>
                        <td>
                            <p class="text-info">{{trans('dashboard::systems/monitor.Memory.Cache')}}</p>
                        </td>
                        <td class="membar-key">
                            <p class="membar-key-free">
                                {{ $memory->free->percentage }}%
                            </p>
                        </td>
                        <td>
                            <p class="text-success">{{trans('dashboard::systems/monitor.Memory.Free')}}</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>

            </div>
        </div>
        <div class="row">
            <!-- Storage -->
            <div class="col-lg-12 widget-less-padding">
                <h4><i class="fa m-r-sm fa-database"></i> {{trans('dashboard::systems/monitor.Storage.Title')}}
                </h4>

                <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th><p>{{trans('dashboard::systems/monitor.Storage.FILESYSTEM')}}</p></th>
                        <th>
                            <p class="text-center">{{trans('dashboard::systems/monitor.Storage.Size')}}</p>
                        </th>
                        <th>
                            <p class="text-center">{{trans('dashboard::systems/monitor.Storage.AVAILABLE')}}</p>
                        </th>
                        <th><p class="text-center">
                                %&nbsp;{{trans('dashboard::systems/monitor.Storage.USED')}}</p></th>
                        <th>
                            <p class="text-right">{{trans('dashboard::systems/monitor.Storage.MOUNTED')}}</p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($storage->storage as $item)
                    <tr v-for="storage in systems.storage.storage">
                        <td><p>{{ $item[0] }}</p></td>
                        <td><p class="text-center">{{ $item[1] }}</p></td>
                        <td><p class="text-center">{{ $item[2] }}</p></td>
                        <td>
                            <div class="progress bg-dark dk">
                                <div class="progress-bar" role="progressbar"
                                     aria-valuenow="{{$item[4]}}" aria-valuemin="0"
                                     aria-valuemax="100"
                                     style="width: {{$item[4]}};">
                                    {{ $item[4] }}
                                </div>
                            </div>
                        </td>
                        <td><p class="text-right">{{ $item[5] }}</p></td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4><i class="fa m-r-sm fa-info"></i> {{trans('dashboard::systems/monitor.Info.Title')}}</h4>
                <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td><p>{{trans('dashboard::systems/monitor.Info.Linux')}}:</p></td>
                        <td><p class="text-right small">{{ $info->uname}}</p></td>
                    </tr>
                    <tr>
                        <td><p>{{trans('dashboard::systems/monitor.Info.Web Server')}}:</p></td>
                        <td><p class="text-right small">{{ $info->webserver  }}</p></td>
                    </tr>
                    <tr>
                        <td><p>{{trans('dashboard::systems/monitor.Info.PHP Version')}}:</p></td>
                        <td><p class="text-right small">{{ $info->php_version }}</p></td>
                    </tr>
                    <tr>
                        <td><p>{{trans('dashboard::systems/monitor.Info.CPU')}}:</p></td>
                        <td><p class="text-right small">{{ $info->cpu }}</p></td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>

        </div>


    </section>

@endsection