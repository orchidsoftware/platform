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
                                    <li class="list-group-item b-b text-center" tabindex="0">Файлы:</li>


                                    @foreach($files as $file)
                                        <a href="{{ route('dashboard.log.show',base64_encode($file)) }}"
                                           class="list-group-item ">
                                            @if ($current_file == $file) <i class="fa fa-angle-right"></i> @endif
                                            {{$file}}
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


                                            <div class="m-b-sm">
                                                <div class="btn-group">
                                                    <a href="{{ route('dashboard.log.download', base64_encode($current_file)) }}"
                                                       class="btn btn-default"><i class="fa fa-download"></i> Download
                                                        file</a>
                                                    <form method="post"
                                                          action="{{ route('dashboard.log.destroy', base64_encode($current_file)) }}"
                                                          class="pull-right">
                                                        {{csrf_field()}}
                                                        {!! method_field('delete') !!}
                                                        <button type="submit" class="btn btn-default"><i
                                                                    class="fa fa-trash"></i> Delete
                                                            file
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div id="log-container">

                                    @if ($logs === null)
                                        <div class="text-center h-full">
                                            <h1>Log file >10M</h1>
                                            <p>please download it</p>
                                            <p><a class="btn btn-primary btn-lg"
                                                  href="{{ route('dashboard.log.download', base64_encode($current_file)) }}"
                                                  role="button"><i
                                                            class="fa fa-download"></i> Download</a></p>
                                        </div>

                                    @else
                                        <table id="table-log" class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th width="10%">Level</th>
                                                <th width="40%">Date</th>
                                                <th width="50%">Content</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($logs as $key => $log)
                                                <tr>
                                                    <td class="text-{{$log['level_class']}}"><span
                                                                class="glyphicon glyphicon-{{$log['level_img']}}-sign"
                                                                aria-hidden="true"></span> &nbsp;{{$log['level']}}</td>
                                                    <td class="date">
                                                        <time data-toggle="tooltip" data-placement="top"
                                                              title="{{$log['date']}}">{{date("d.m.y",strtotime($log['date']))}}</time>
                                                    </td>
                                                    <td class="text">
                                                        @if ($log['stack']) <a
                                                                class="pull-right  btn btn-default btn-xs"
                                                                data-display="stack{{$key}}"><span
                                                                    class="fa fa-search"></span></a>@endif
                                                        {{$log['text']}}
                                                        @if (isset($log['in_file'])) <br/>{{$log['in_file']}}@endif
                                                        @if ($log['stack'])
                                                            <div class="stack" id="stack{{$key}}"
                                                                 style="display: none; white-space: pre-wrap;">{{ trim($log['stack']) }}
                                                            </div>@endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    @endif


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

