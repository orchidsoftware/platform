@extends('dashboard::layouts.dashboard')


@section('title',$name)
@section('description',$description)


@section('navbar')
    <div class="col-sm-6 col-xs-12 text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('dashboard.systems.roles.create')}}" class="btn btn-link"><i
                        class="icon-plus fa fa-2x"></i></a>
        </div>
    </div>
@stop


@section('content')


    <!-- main content  -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs">

            @if($roles->count() > 0)
                <div class="panel">

                    <div class="panel-body row">


                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="w-xs">{{trans('dashboard::common.Manage')}}</th>
                                    <th>{{trans('dashboard::systems/roles.name')}}</th>
                                    <th>{{trans('dashboard::systems/roles.slug')}}</th>
                                    <th>{{trans('dashboard::common.Last edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('dashboard.systems.roles.edit',$role->slug) }}"><i
                                                        class="fa fa-bars"></i></a>
                                        </td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->slug }}</td>

                                        <td>{{ $role->updated_at or $role->created_at }}</td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8">
                                <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$roles->total()}}
                                    -{{$roles->perPage()}} {{trans('dashboard::common.of')}} {!! $roles->count() !!} {{trans('dashboard::common.elements')}}</small>
                            </div>
                            <div class="col-sm-4 text-right text-center-xs">
                                {!! $roles->render() !!}
                            </div>
                        </div>
                    </footer>
                </div>

            @else

                <div class="jumbotron text-center bg-white not-found">
                    <div>
                        <h3 class="font-thin">{{trans('dashboard::systems/roles.not_found')}}</h3>

                        <a href="{{ route('dashboard.systems.roles.create')}}"
                           class="btn btn-link">{{trans('dashboard::systems/roles.create')}}</a>
                    </div>
                </div>

            @endif

        </div>
    </section>
    <!-- / main content  -->


@stop




