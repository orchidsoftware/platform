@extends('dashboard::layouts.dashboard')
@section('title',$name)
@section('description',$description)


@section('navbar')

    <ul class="nav justify-content-end v-center">
        @foreach($screen->commandBar() as $command)
            <li>
                {!! $command->build($arguments) !!}
            </li>
        @endforeach
    </ul>

@stop

@section('content')

    <section>
        <div class="bg-white b-b box-shadow">
            <form id="post-form" method="post" enctype="multipart/form-data">
                @foreach($screen->build() as $views)
                    {!! $views or '' !!}
                @endforeach

                {{csrf_field()}}
            </form>
        </div>
    </section>

    <div id="modals-container">
         @yield('modals-container')
    </div>


    <form id="filters"></form>
@stop
