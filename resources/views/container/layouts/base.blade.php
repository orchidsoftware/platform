@extends('dashboard::layouts.dashboard')
@section('title',$name)
@section('description',$description)


@section('navbar')

    <ul class="nav navbar-nav navbar-right v-center">
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

    <form id="filters"></form>
@stop
