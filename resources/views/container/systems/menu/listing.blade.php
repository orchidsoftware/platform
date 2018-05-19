@extends('platform::layouts.dashboard')

@section('title',trans('platform::systems/menu.title'))
@section('description',trans('platform::systems/menu.description'))

@section('content')



    <!-- main content  -->
    <section>
        <div class="bg-white-only bg-auto no-border-xs">
            <div class="card">
                <div class="card-body row no-gutter">
                @if($menu->count() > 0)

                    <h4 class="font-thin mt-4">{{trans('platform::systems/menu.description')}}</h4>
                    <div class="list-group list-group-flush text-left col-md-12">
                        @foreach ($menu as $key => $value)
                                <a href="{{ route('platform.systems.menu.show',$key) }}" class="list-group-item list-group-item-action">{{ $value }}</a>
                        @endforeach

                    </div>

                @else

                    <div class="jumbotron text-center bg-white not-found">
                        <div>
                            <h3 class="font-thin">{{trans('platform::systems/menu.not_found')}}</h3>
                        </div>
                    </div>

                @endif

                </div>
            </div>
        </div>
    </section>
    <!-- / main content  -->


@stop
