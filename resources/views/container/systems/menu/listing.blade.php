@extends('dashboard::layouts.dashboard')

@section('title',trans('dashboard::systems/menu.title'))
@section('description',trans('dashboard::systems/menu.description'))

@section('content')


    <!-- main content  -->
    <section class="wrapper-md">
        <div class="bg-white-only bg-auto no-border-xs">

            @if($menu->count() > 0)
                <div class="card">

                    <div class="card-body row">

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="w-xs">{{trans('dashboard::common.Manage')}}</th>
                                    <th>{{trans('dashboard::systems/menu.form.title')}}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($menu as $key => $value)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('dashboard.systems.menu.show',$key) }}"><i class="fa fa-bars"></i></a>
                                        </td>
                                        <td>{{ $value }}</td>

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
                        <h3 class="font-thin">{{trans('dashboard::systems/menu.not_found')}}</h3>
                    </div>
                </div>

            @endif

        </div>
    </section>
    <!-- / main content  -->


@stop
