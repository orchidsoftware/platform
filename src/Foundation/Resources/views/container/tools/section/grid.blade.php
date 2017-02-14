@extends('dashboard::layouts.dashboard')


@section('title',$name)
@section('description',$description)




@section('navbar')
    <div class="col-sm-6 col-xs-12 text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('dashboard.tools.section.create')}}" class="btn btn-link"><i class="icon-plus fa fa-2x"></i></a>
        </div>
    </div>
@stop



@section('content')


    <!-- main content -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs">

        @if($sections->count() > 0)
            <div class="panel">

                <div class="panel-body row">


                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="w-xs">{{trans('dashboard::common.Manage')}}</th>
                                <th>Имя</th>
                                <th>{{trans('dashboard::common.Last edit')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($sections as $section)
                                <tr>
                                    <td class="text-center">
                                        <a href="{{ route('dashboard.tools.section.edit',$section->slug) }}"><i
                                                    class="fa fa-bars"></i></a>
                                    </td>
                                    <td>{{ $section->getTree(' > ') }}</td>

                                    <td>{{ $section->updated_at}}</td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8">
                            <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$sections->total()}}
                                -{{$sections->perPage()}} {{trans('dashboard::common.of')}} {!! $sections->count() !!} {{trans('dashboard::common.elements')}}</small>
                        </div>
                        <div class="col-sm-4 text-right text-center-xs">
                            {!! $sections->render() !!}
                        </div>
                    </div>
                </footer>
            </div>

        @else

            <div class="jumbotron text-center">
                <h3 class="font-thin">Вы ещё не создали ни одной секции</h3>

                <a href="{{ route('dashboard.tools.section.create')}}" class="btn btn-link">Создать</a>
            </div>

        @endif

        </div>
    </section>
    <!-- / main content -->


@stop




