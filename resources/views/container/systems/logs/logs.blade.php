@extends('dashboard::layouts.dashboard')


@section('title',trans('dashboard::logs.title'))
@section('description',trans('dashboard::logs.description'))





@section('content')


    <!-- main content  -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs">


            <div class="panel">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            @foreach($headers as $key => $header)
                                <th class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                    @if ($key == 'date')
                                        <span class="text-dark m-n">{{ $header }}</span>
                                    @else
                                        <span class="text-dark level level-{{ $key }}">

                                <i class="{!! log_styler()->icon($key) !!}" title="{{$header}}"></i>
                            </span>
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @if ($rows->count() > 0)
                            @foreach($rows as $date => $row)
                                <tr>
                                    @foreach($row as $key => $value)
                                        <td class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                            @if ($key == 'date')
                                                <span class="font-thin m-n">{{ $value }}</span>
                                            @elseif ($value == 0)
                                                <span class="level level-empty">{{ $value }}</span>
                                            @else
                                                <a href="{{ route('dashboard.systems.logs.show', [$date, $key])}}">
                                                    <span class="level level-{{ $key }}">{{ $value }}</span>
                                                </a>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="text-center">
                                    <span class="label label-default">{{ trans('dashboard::logs.empty-logs') }}</span>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
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


@endsection


