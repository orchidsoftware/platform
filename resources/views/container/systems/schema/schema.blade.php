@extends('dashboard::layouts.dashboard')


@section('title','База данных')
@section('description','Таблицы')



@section('content')


    <!-- main content -->
    <section class="wrapper">


        <div class="panel-group" id="tables-accordion" role="tablist" aria-multiselectable="true">

            @foreach ($tables as $name => $table)



                <div class="panel">

                    <div class="panel-heading">

                        <div class="row">
                            <div class="col-md-6">


                                <h5>
                                    <a href="{{route('dashboard.systems.schema.show',$name)}}"> {{$name}}</a>
                                    <small>({{ $table['rowsCount'] }})</small>
                                </h5>
                            </div>

                            <div class="col-md-6 text-right">
                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-parent="#tables-accordion" data-target="#table-{{$name}}"
                                        aria-expanded="false" aria-controls="table-{{$name}}">
                                    Show Attributes
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="collapse" id="table-{{$name}}">
                        <div class="panel-body row">

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        @foreach($table['attributes'] as $attributes)
                                            @if ($loop->first)
                                                @foreach($attributes as $key=> $attribute)
                                                    <th>{{$key}}</th>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($table['attributes'] as $attributes)
                                        <tr>
                                            @foreach($attributes as $key=> $attribute)
                                                <td>
                                                    <small>{{$attribute}}</small>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>


                </div>

            @endforeach
        </div>


    </section>
    <!-- / main content -->


@stop

