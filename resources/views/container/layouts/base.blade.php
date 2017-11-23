@extends('dashboard::layouts.dashboard')
@section('title',$name)
@section('description',$description)


@section('navbar')

    <ul class="nav navbar-nav navbar-right v-center">
        @foreach($screen->commandBar() as $command)
            <li>
                <button type="submit"
                        formaction="{{route(Route::currentRouteName(),$arguments)}}/{{$command['method'] or ''}}"
                        form="post-form"
                        class="btn btn-sm btn-link">
                    <i class="{{$command['icon'] or ''}}"></i>{{$command['displayName'] or ''}}
                </button>
            </li>
        @endforeach
    </ul>

@stop

@section('content')

    <section class="wrapper-md">
        <div class="bg-white b-b box-shadow">
            <form id="post-form" method="post" enctype="multipart/form-data">
                @foreach($screen->build() as $views)
                    {!! $views or '' !!}
                @endforeach

                {{csrf_field()}}
            </form>
        </div>
    </section>

@stop
