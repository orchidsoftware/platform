@extends('dashboard::layouts.dashboard')


@section('title',$table)
@section('description', trans('dashboard::systems/schema.description'))




@section('content')


    <!-- main content  -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs">


            <div class="panel">

                <div class="panel-body row">


                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                @foreach($columns as $column)
                                    <th>{{$column['Field']}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    @foreach($row as $key => $value)
                                        <td><span class="text-ellipsis">{{ str_limit($value,100)}}</span></td>
                                    @endforeach
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8">
                            <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$rows->total()}}
                                -{{$rows->perPage()}} {{trans('dashboard::common.of')}} {!! $rows->count() !!} {{trans('dashboard::common.elements')}}</small>
                        </div>
                        <div class="col-sm-4 text-right text-center-xs">
                            {!! $rows->render() !!}
                        </div>
                    </div>
                </footer>
            </div>


        </div>
    </section>
    <!-- / main content  -->


@stop




