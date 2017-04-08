@extends('dashboard::layouts.dashboard')


@section('title',trans('dashboard::systems/defender.title'))
@section('description',trans('dashboard::systems/defender.description'))





@section('content')


    <!-- main content -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs">

            @if(count($list))
            <div class="panel">

                <div class="panel-body row">


                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>{{trans('dashboard::systems/defender.path')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($list as $value)
                                <tr>
                                    <td>{{$value}}</td>
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
                        <h3 class="font-thin">Опасных файлов не найдено или проверка ещё не проводилась</h3>
                    </div>
                </div>

            @endif

        </div>
    </section>
    <!-- / main content -->


@stop




