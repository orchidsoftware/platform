@extends('dashboard::layouts.dashboard')


@section('title','Защитник')
@section('description','Резервные копии системы')





@section('content')


    <!-- main content -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs">


            <div class="panel">

                <div class="panel-body row">


                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Путь к файлу</th>
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


        </div>
    </section>
    <!-- / main content -->


@stop




