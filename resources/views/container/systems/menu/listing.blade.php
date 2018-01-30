@extends('dashboard::layouts.dashboard')

@section('title',trans('dashboard::systems/menu.title'))
@section('description',trans('dashboard::systems/menu.description'))

@section('content')



    <!-- main content  -->
    <section>
        <div class="bg-white-only bg-auto no-border-xs">

            @if($menu->count() > 0)


                <div class="jumbotron text-center bg-white not-found">
                    <div>
                        <h3 class="font-thin">{{trans('dashboard::systems/menu.description')}}</h3>
                        <ul class="text-left">
                            @foreach ($menu as $key => $value)

                                <li>
                                    <a href="{{ route('dashboard.systems.menu.show',$key) }}">{{ $value }}</a>
                                </li>
                            @endforeach

                        </ul>
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
