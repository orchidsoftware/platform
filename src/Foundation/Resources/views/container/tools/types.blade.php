@extends('dashboard::layouts.dashboard')

@section('content')





    <div class="app-content-full">

        <div class="hbox hbox-auto-xs hbox-auto-sm bg-light">

            <!-- column -->
            <div class="col w b-r">
                <div class="vbox">
                    <div class="row-row">
                        <div class="cell scrollable hover">
                            <div class="cell-inner">

                                <div class="list-group no-radius no-border no-bg m-b-none">
                                    <li class="list-group-item b-b text-center" tabindex="0">Типы:</li>

                                    @foreach($Types as $type)
                                        <a href="{{ route('dashboard.types.show',$type->slug) }}"
                                           class="list-group-item m-l hover-anchor b-a" tabindex="0">
                                            <span class="pull-right text-muted hover-action" role="button" tabindex="0"><i
                                                        class="fa fa-times"></i></span>
                                            <span class="block m-l-n">{{$type->name}}</span>
                                        </a>
                                    @endforeach

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col bg-white-only">
                <div class="vbox">

                    <div class="row-row">
                        <div class="cell">
                            <div class="cell-inner">


                                <div class="bg-light lter b-b wrapper-md">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <h1 class="m-n font-thin h3">Системный журнал</h1>
                                            <small class="text-muted">файлы, содержащие системную информацию работы
                                                программного обеспечения, в которых протоколируются действия для
                                                анализа.
                                            </small>
                                        </div>


                                        <div class="col-sm-6 text-right hidden-xs">

                                        </div>
                                    </div>
                                </div>

                                <div id="log-container">

                                    <table id="table-log" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th width="10%">Level</th>
                                            <th width="40%">Date</th>
                                            <th width="50%">Content</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /column -->


        </div>
    </div>






















@endsection

