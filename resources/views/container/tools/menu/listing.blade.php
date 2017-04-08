@extends('dashboard::layouts.dashboard')


@section('title','Меню')
@section('description','Выберите доступное меню')






@section('content')


    <!-- main content -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs">

            @if($menu->count() > 0)
                <div class="panel">

                    <div class="panel-body row">


                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="w-xs">{{trans('dashboard::common.Manage')}}</th>
                                    <th>Имя</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($menu as $key => $value)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('dashboard.tools.menu.show',$key) }}"><i
                                                        class="fa fa-bars"></i></a>
                                        </td>
                                        <td>{{ $value }}</td>

                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>

            @else

                <div class="jumbotron text-center bg-white not-found">
                    <div>
                    <h3 class="font-thin">Нет доступных меню</h3>
                    </div>
                </div>

            @endif

        </div>
    </section>
    <!-- / main content -->


@stop




