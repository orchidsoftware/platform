@extends('dashboard::layouts.dashboard')


@section('title','Журнал ошибок')
@section('description','Журнал не системных вызовов')




@section('navbar')
    <div class="col-sm-6 col-xs-12 text-right">
        <div class="btn-group" role="group">
            <a href="#" class="btn btn-link"><i class="ion-ios-plus-outline fa fa-2x"></i></a>
        </div>
    </div>
@stop



@section('content')


    <!-- main content -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs">


            <div class="panel">

                <div class="panel-body row">

                    <div class="col-md-3">
                        <canvas id="stats-doughnut-chart" height="300"></canvas>
                    </div>
                    <div class="col-md-9">
                        <section class="box-body">
                            <div class="row text-center">
                                @foreach($percents as $level => $item)
                                    <div class="col-md-4">


                                        <div class="panel padder-v item wrapper b b-light">
                                            <div class="h1 text-info font-thin h1">{{ $item['count'] }}</div>
                                            <span class="text-muted text-xs">{{ $item['name'] }}</span>

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width: {{ $item['percent'] }}%;">
                                                    {{ $item['percent'] }} %
                                                </div>
                                            </div>


                                            <div class="top text-right w-full wrapper-sm">
                                                <i class="{{log_styler()->icon($level)}} fa-2x "></i>
                                            </div>
                                        </div>


                                    <!--
                                                <div class="info-box level level-{{ $level }} {{ $item['count'] === 0 ? 'level-empty' : '' }}">
                                <span class="info-box-icon">
                                    {!! log_styler()->icon($level) !!}
                                            </span>

                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">{{ $item['name'] }}</span>
                                                        <span class="info-box-number">
                                        {{ $item['count'] }} entries - {!! $item['percent'] !!} %
                                    </span>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: {{ $item['percent'] }}%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                -->
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>

                </div>


            </div>


        </div>
    </section>
    <!-- / main content -->

    <script>
        window.onload = function () {

            $(function () {
                new Chart($('canvas#stats-doughnut-chart'), {
                    type: 'doughnut',
                    data: {!! $chartData !!},
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                });
            });
        }
    </script>

@stop




