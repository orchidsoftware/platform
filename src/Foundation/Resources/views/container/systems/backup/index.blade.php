@extends('dashboard::layouts.dashboard')


@section('title','Резервные копии')
@section('description','Резервные копии системы')




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

            @if(true)
                <div class="panel">

                    <div class="panel-body row">


                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="w-xs">{{trans('dashboard::common.Manage')}}</th>
                                    <th>Размещение</th>
                                    <th>{{trans('dashboard::common.Last edit')}}</th>
                                    <th class="text-right">Размер</th>
                                    <th class="text-right">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($backups as $backup)
                                    <tr>
                                        <td class="text-center">
                                            <a href="#"><i
                                                        class="fa fa-bars"></i></a>
                                        </td>
                                        <td>{{ $backup['disk'] }}</td>
                                        <td>{{ \Carbon\Carbon::createFromTimeStamp($backup['last_modified'])->formatLocalized('%d %B %Y, %H:%M') }}</td>
                                        <td class="text-right">{{ round((int)$backup['file_size']/1048576, 2).' MB' }}</td>
                                        <td class="text-right">
                                            @if ($backup['download'])
                                                <a class="btn btn-xs btn-default"
                                                   href="#?disk={{ $backup['disk'] }}&path={{ urlencode($backup['file_path']) }}&file_name={{ urlencode($backup['file_name']) }}"><i
                                                            class="fa fa-cloud-download"></i> {{ trans('backpack::backup.download') }}
                                                </a>
                                            @endif
                                            <a class="btn btn-xs btn-danger" data-button-type="delete"
                                               href="#{{ $backup['file_name'] }}?disk={{ $backup['disk'] }}"><i
                                                        class="fa fa-trash-o"></i> {{ trans('backpack::backup.delete') }}
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>

            @else

                <div class="jumbotron text-center">
                    <h3 class="font-thin">Вы ещё не создали ни одной секции</h3>
                    <a href="#" class="btn btn-link">Создать</a>
                </div>

            @endif

        </div>
    </section>
    <!-- / main content -->


@stop




