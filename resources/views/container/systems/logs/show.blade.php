@extends('dashboard::layouts.dashboard')


@section('title',trans('dashboard::logs.title'))
@section('description',  $log->getPath() )




@section('navbar')
    <div class="col-sm-6 col-xs-12 text-right">

        <ul class="nav navbar-nav navbar-right">

            <li>
                <a href="{{-- route('log-viewer::logs.download', [$log->date]) --}}" class="btn btn-link menu-save"><i
                            class="icon-cloud-download fa fa-2x"></i></a>
            </li>

            <li>
                <a href="#delete-log-modal" class="btn btn-link " data-toggle="modal">
                    <i class="icon-trash fa fa-2x"></i>
                </a>
            </li>

        </ul>

    </div>
@stop



@section('content')



    <div class="hbox hbox-auto-xs hbox-auto-sm" id="menu-vue">


        <div class="col w-xxl bg-white-only b-r bg-auto no-border-xs">

            <div class="panel-heading"><i class="fa fa-fw fa-flag"></i> Levels</div>
            <ul class="list-group  m-b-n-xs">
                @foreach($log->menu() as $level => $item) {{-- $log->menu()  --}}
                @if ($item['count'] === 0)
                    <a href="#" class="list-group-item disabled">
                <span class="badge">
                    {{ $item['count'] }}
                </span>
                        <i class="{{ $item['icon'] }}"></i> {{ $item['name'] }}
                    </a>
                @else
                    <a href="{{ $item['url'] }}" class="list-group-item {{ $level }}">
                <span class="badge level-{{ $level }}">
                    {{ $item['count'] }}
                </span>
                        <span class="level level-{{ $level }}">
                     <i class="{{ $item['icon'] }}"></i> {{ $item['name'] }}
                </span>
                    </a>
                @endif
                @endforeach
            </ul>


            <ul class="list-group">

                <li class="list-group-item">
                    <small>Log entries : {{ $entries->total() }}</small>
                </li>
                <li class="list-group-item">
                    <small>Size : {{ $log->size() }}</small>
                </li>
                <li class="list-group-item">
                    <small>Created at : {{ $log->createdAt() }}</small>
                </li>
                <li class="list-group-item">
                    <small>Updated at : {{ $log->updatedAt() }}</small>
                </li>
            </ul>


        </div>


        <!-- main content -->
        <div class="col">
            <section class="wrapper-md">


                <div class="bg-white-only bg-auto no-border-xs">


                    <div class="panel">

                        <div class="row wrapper">


                            <div class="panel ">

                                <div class="table-responsive">
                                    <table id="entries" class="table table-condensed">
                                        <thead>
                                        <tr>
                                            <th width="10%">ENV</th>
                                            <th width="10%">Time</th>
                                            <th>Header</th>
                                            <th width="10%" class="text-right">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($entries as $key => $entry)
                                            <tr>
                                                <td>
                                                <span class="label label-env text-dark">
                                                      <i class="{{$entry->level()}}"></i>
                                                    {{ $entry->env }}</span>
                                                </td>

                                                <td>{{ $entry->datetime->format('H:i:s') }}</td>
                                                <td>
                                                    <p class="">{{ $entry->header }}</p>
                                                </td>
                                                <td class="text-right">
                                                    @if ($entry->hasStack())
                                                        <a class="btn btn-xs btn-default" role="button"
                                                           data-toggle="collapse" href="#log-stack-{{ $key }}"
                                                           aria-expanded="false" aria-controls="log-stack-{{ $key }}">
                                                            <i class="fa fa-toggle-on"></i> Stack
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($entry->hasStack())
                                                <tr>
                                                    <td colspan="4" class="stack">
                                                            <pre class="stack-content collapse bg-black"
                                                                 id="log-stack-{{ $key }}">
                                                                {!! $entry->stack() !!}
                                                            </pre>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if ($entries->hasPages())
                                    <footer class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$entries->total()}}
                                                    -{{$entries->perPage()}} {{trans('dashboard::common.of')}} {!! $entries->count() !!} {{trans('dashboard::common.elements')}}</small>
                                            </div>
                                            <div class="col-sm-4 text-right text-center-xs">
                                                {!! $entries->render() !!}
                                            </div>
                                        </div>
                                    </footer>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

            </section>

            {{-- DELETE MODAL --}}
            <div id="delete-log-modal" class="modal fade">
                <div class="modal-dialog">
                    <form id="delete-log-form" action="{{-- route('log-viewer::logs.delete') --}}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="date" value="{{ $log->date }}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">DELETE LOG FILE</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <span class="label label-danger">DELETE</span> this log file
                                    <span
                                            class="label label-primary">{{ $log->date }}</span> ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">
                                    DELETE
                                    FILE
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>


    </div>





    <script>
        $(function () {
            var deleteLogModal = $('div#delete-log-modal'),
                deleteLogForm = $('form#delete-log-form'),
                submitBtn = deleteLogForm.find('button[type=submit]');

            deleteLogForm.on('submit', function (event) {
                event.preventDefault();
                submitBtn.button('loading');

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function (data) {
                        submitBtn.button('reset');
                        if (data.result === 'success') {
                            deleteLogModal.modal('hide');
                            location.replace("{{-- route('log-viewer::logs.list') --}}");
                        }
                        else {
                            alert('OOPS ! This is a lack of coffee exception !')
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(errorThrown);
                        submitBtn.button('reset');
                    }
                });

                return false;
            });
        });
    </script>

@stop
